<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

$book_id = (int)($_GET['book_id'] ?? 0);

if ($book_id <= 0) {
    header("Location: shop.php");
    exit();
}

// Get book details
$sqlBook = "SELECT b.discount_percentage, b.book_name, b.price, b.book_description, b.stock, b.isbn,
            a.author_name, c.name as category_name, p.publisher_name,
            i.image_path
            FROM Books b
            LEFT JOIN Book_Author ba ON ba.book_id = b.book_id 
            LEFT JOIN Authors a ON a.author_id = ba.author_id
            LEFT JOIN Book_Category bc ON bc.book_id = b.book_id
            LEFT JOIN Categories c ON c.category_id = bc.category_id
            LEFT JOIN Publishers p ON p.publisher_id = b.publisher_id
            LEFT JOIN Images i ON b.book_id = i.book_id AND i.is_main = 1
            WHERE b.book_id = ?";

$resultBook = selectQuery($conn, $sqlBook, "i", [$book_id]);

if ($resultBook->num_rows === 0) {
    $_SESSION['error_message'] = "Book not found!";
    header("Location: shop.php");
    exit();
}

$rowBook = $resultBook->fetch_assoc();

// Get reviews
$sqlReview = "SELECT u.name, r.rating, r.review_comment, r.created_at 
              FROM Reviews r
              JOIN users u ON u.user_id = r.user_id
              WHERE r.book_id = ?
              ORDER BY r.created_at DESC";

$resultReview = selectQuery($conn, $sqlReview, "i", [$book_id]);

// Calculate average rating
$sqlAvg = "SELECT COUNT(rating) as num, AVG(rating) AS avg FROM Reviews WHERE book_id = ?";
$resultAvg = selectQuery($conn, $sqlAvg, "i", [$book_id]);
$avgRow = $resultAvg->fetch_assoc();

$avgRating = (float)($avgRow['avg'] ?? 0);
$starsFilled = (int) round($avgRating);
$numOfReviews = $avgRow['num'];

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCart'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "Please login to add items to cart!";
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $quantity = (int)($_POST['quantity'] ?? 1);

    if ($quantity > 0 && $quantity <= $rowBook['stock']) {
        // Check if already in cart
        $sqlCheck = "SELECT cart_id, quantity FROM Cart WHERE user_id = ? AND book_id = ?";
        $resultCheck = selectQuery($conn, $sqlCheck, "ii", [$user_id, $book_id]);

        if ($resultCheck->num_rows > 0) {
            $cartRow = $resultCheck->fetch_assoc();
            $newQty = $cartRow['quantity'] + $quantity;

            $sqlUpdate = "UPDATE Cart SET quantity = ? WHERE cart_id = ?";
            executeQuery($conn, $sqlUpdate, "ii", [$newQty, $cartRow['cart_id']]);
        } else {
            $sqlInsert = "INSERT INTO Cart (user_id, book_id, quantity) VALUES (?, ?, ?)";
            executeQuery($conn, $sqlInsert, "iii", [$user_id, $book_id, $quantity]);
        }

        $_SESSION['success_message'] = "Book added to cart!";
        header("Location: cart.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid quantity!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($rowBook['book_name']) ?> | BookSphere</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <!-- Simple Header -->
    <div class="border-bottom py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="shop.php" class="text-decoration-none">
                    <h4 class="mb-0">BookSphere</h4>
                </a>

                <div class="d-flex gap-3 align-items-center">
                    <a href="shop.php" class="text-decoration-none">Shop</a>
                    <a href="profile.php" class="text-decoration-none">Account</a>
                    <a href="wishlist.php" class="text-decoration-none"><i class="lni lni-heart"></i> Wishlist</a>
                    <a href="cart.php" class="text-decoration-none"><i class="lni lni-cart"></i> Cart</a>
                    <a href="orders.php" class="text-decoration-none">Orders</a>
                    <a href="logout.php" class="text-decoration-none text-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">

        <!-- Error Messages -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($rowBook['book_name']) ?></li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Image -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php if (!empty($rowBook['image_path'])):
                            $image = str_replace(' ', '%20', $rowBook['image_path']);
                            // $image = ltrim($image, '/');
                        ?>
                            <img src="<?= '../admin/' . $image ?>"
                                alt="Book cover"
                                class="w-100 rounded"
                                style="height:450px;object-fit:cover;">
                        <?php else: ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:450px;">
                                <i class="lni lni-book" style="font-size: 5rem; color: #ddd;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-1"><?= htmlspecialchars($rowBook['book_name']) ?></h3>
                        <p class="text-muted mb-2">by <strong><?= htmlspecialchars($rowBook['author_name'] ?? 'Unknown') ?></strong></p>

                        <!-- Rating -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div>
                                <?php for ($i = 0; $i < $starsFilled; $i++): ?>
                                    <i class="lni lni-star-filled text-warning"></i>
                                <?php endfor; ?>
                                <?php for ($i = $starsFilled; $i < 5; $i++): ?>
                                    <i class="lni lni-star text-warning"></i>
                                <?php endfor; ?>
                            </div>
                            <small class="text-muted">(<?= number_format($avgRating, 1) ?> - <?= $numOfReviews ?> Reviews)</small>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <!-- <?php
                                    $discount = (int)($rowBook['discount_percentage'] ?? 0);
                                    $finalPrice = $rowBook['price'];

                                    if ($discount > 0) {
                                        $finalPrice = $finalPrice - ($finalPrice * $discount / 100);
                                    }
                                    ?> -->
                            <h4 class="mb-0 text-primary">$<?= number_format($rowBook['price'], 2) ?></h4>
                            <!-- <span style="text-decoration: line-through;"><?= '$' . $finalPrice ?></span> -->
                        </div>
                        <!-- <span class="badge bg-success"><?= '%' . $rowBook['discount_percentage'] ?></span> -->

                        <?php if ($rowBook['stock'] > 0): ?>
                            <span class="badge bg-success">In Stock (<?= $rowBook['stock'] ?> available)</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Out of Stock</span>
                        <?php endif; ?>
                        <p class="mb-4"><?= nl2br(htmlspecialchars($rowBook['book_description'])) ?></p>


                        <!-- Actions -->
                        <?php if ($rowBook['stock'] > 0): ?>
                            <form method="POST" action="">
                                <div class="row g-2 mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="quantity" value="1"
                                            min="1" max="<?= $rowBook['stock'] ?>" required>
                                    </div>
                                    <div class="col-md-9 d-flex gap-2 align-items-end">
                                        <button type="submit" name="addToCart" class="btn btn-primary">
                                            <i class="lni lni-cart"></i> Add to Cart
                                        </button>
                                        <a href="shop.php" class="btn btn-outline-secondary">
                                            <i class="lni lni-arrow-left"></i> Back to Shop
                                        </a>
                                    </div>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="lni lni-warning"></i> This book is currently out of stock.
                            </div>
                            <a href="shop.php" class="btn btn-outline-secondary">
                                <i class="lni lni-arrow-left"></i> Back to Shop
                            </a>
                        <?php endif; ?>

                        <!-- Info -->
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Category</small>
                                    <strong><?= htmlspecialchars($rowBook['category_name'] ?? 'N/A') ?></strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Publisher</small>
                                    <strong><?= htmlspecialchars($rowBook['publisher_name'] ?? 'N/A') ?></strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">ISBN</small>
                                    <strong><?= htmlspecialchars($rowBook['isbn'] ?? 'N/A') ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="mb-3">Customer Reviews (<?= $numOfReviews ?>)</h5>

            <?php if ($resultReview->num_rows > 0): ?>
                <?php while ($rowReview = $resultReview->fetch_assoc()): ?>
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <strong><?= htmlspecialchars($rowReview['name']) ?></strong>
                            <small class="text-muted"><?= date('M d, Y', strtotime($rowReview['created_at'])) ?></small>
                        </div>
                        <div class="mb-2">
                            <?php for ($i = 0; $i < $rowReview['rating']; $i++): ?>
                                <i class="lni lni-star-filled text-warning"></i>
                            <?php endfor; ?>
                            <?php for ($i = $rowReview['rating']; $i < 5; $i++): ?>
                                <i class="lni lni-star text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <?php if (!empty($rowReview['review_comment'])): ?>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($rowReview['review_comment'])) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted text-center">No reviews yet. Be the first to review this book!</p>
            <?php endif; ?>
        </div>
    </div>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>