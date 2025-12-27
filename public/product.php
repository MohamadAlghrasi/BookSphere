<?php
require_once __DIR__ . '/../helpers/db_queries.php';
$book_id = $_GET['book_id'];

// Queries
$sqlBook = "SELECT  books.book_name, books.price, books.book_description, books.stock, books.quantity, authors.author_name, categories.name from books
        JOIN book_author on book_author.book_id = books.book_id 
        JOIN authors on authors.author_id = book_author.author_id
        JOIN book_category ON book_category.book_id = books.book_id
        JOIN categories ON categories.category_id = book_category.category_id
        WHERE books.book_id = ?";

$resultBook = selectQuery($conn, $sqlBook, "i", [$book_id]);
$rowBook = $resultBook->fetch_assoc();
// --
$sqlReview = "SELECT users.name, rating, review_comment, reviews.created_at from reviews 
        join books on books.book_id = reviews.book_id
        join users on users.user_id = reviews.user_id where books.book_id = ?;";

$resultReview = selectQuery($conn, $sqlReview, "i", [$book_id]);
// --
$sqlAvg = "SELECT count(rating) as num, AVG(rating) AS avg FROM reviews WHERE book_id = ?";
$resultAvg = selectQuery($conn, $sqlAvg, "i", [$book_id]);
$avgRow = $resultAvg->fetch_assoc();

$avgRating = (float)($avgRow['avg'] ?? 0);
$starsFilled = (int) round($avgRating);
$numOfReviews = $avgRow['num'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Book Details | BookSphere</title>
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

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Book Details</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Image -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="bg-light rounded" style="height:380px;"></div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-1"><?= $rowBook['book_name'] ?></h3>
                        <p class="text-muted mb-2">by <strong><?= $rowBook['author_name'] ?></strong></p>

                        <!-- Rating (UI only) -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="mb-2">
                                <?php $stars = $starsFilled;
                                while ($stars > 0): ?>
                                    <i class="lni lni-star-filled"></i>
                                <?php
                                    $stars--;
                                endwhile; ?>
                                <?php $remaining = (5 - $starsFilled);
                                while ($remaining > 0): ?>
                                    <i class="lni lni-star"></i>
                                <?php $remaining--;
                                endwhile; ?>
                            </div>
                            <!-- Here, if there's enought time calculate avg -->
                            <small class="text-muted"><?= "( " . $avgRating . ", &nbsp;&nbsp;&nbsp;" . $numOfReviews . " Reviews )" ?></small>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <h4 class="mb-0"><?= $rowBook['price'] ?></h4>
                            <span class="badge bg-success">-10%</span>
                            <small class="text-muted text-decoration-line-through"><?= $rowBook['price'] ?></small>
                        </div>

                        <p class="mb-4"><?= $rowBook['book_description'] ?></p>

                        <!-- Actions -->
                        <div class="row g-2 mb-4">
                            <div class="col-md-4">
                                <input type="number" class="form-control" value="1" min="1">
                            </div>
                            <div class="col-md-8 d-flex gap-2">
                                <button class="btn btn-primary w-100">
                                    <i class="lni lni-cart"></i> Add to Cart
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="lni lni-heart"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Category</small>
                                    <strong><?= $rowBook['name'] ?></strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Stock</small>
                                    <strong><?php if ($rowBook['stock'] >= 1): ?>
                                            <span class="badge bg-success">InStock</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Out Of Stock</span>
                                        <?php endif ?>
                                    </strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">SKU</small>
                                    <strong>BK-001</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews (UI only) -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h5 class="mb-3">Reviews</h5>
                <?php
                if ($resultReview->num_rows > 0) {
                    while ($rowReview = $resultReview->fetch_assoc()) {
                ?>
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong><?= $rowReview['name'] ?></strong>
                                <small class="text-muted"><?= $rowReview['created_at'] ?></small>
                            </div>
                            <div class="mb-2">
                                <?php $filled = $rowReview['rating'];
                                while ($filled > 0): ?>
                                    <i class="lni lni-star-filled"></i>
                                <?php
                                    $filled--;
                                endwhile; ?>
                                <?php $empty = (5 - $rowReview['rating']);
                                while ($empty > 0): ?>
                                    <i class="lni lni-star"></i>
                                <?php $empty--;
                                endwhile; ?>
                            </div>
                            <p class="mb-0"><?= $rowReview['review_comment'] ?></p>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>