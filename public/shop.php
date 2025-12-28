<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

// Get filter parameters
$searchBar = trim($_GET['searchBar'] ?? '');
$category = $_GET['category'] ?? '';
$sortBy = $_GET['sort'] ?? '';

// Build query dynamically
$sql = "SELECT b.discount_percentage ,b.book_id, b.book_name, b.price, b.stock, a.author_name, c.name as category_name, i.image_path
        FROM Books b
        LEFT JOIN Book_Author ba ON b.book_id = ba.book_id 
        LEFT JOIN Authors a ON a.author_id = ba.author_id
        LEFT JOIN Book_Category bc ON b.book_id = bc.book_id
        LEFT JOIN Categories c ON c.category_id = bc.category_id
        LEFT JOIN Images i ON b.book_id = i.book_id AND i.is_main = 1
        WHERE 1=1";

$params = [];
$types = "";

// Add search filter
if (!empty($searchBar)) {
    $sql .= " AND b.book_name LIKE ?";
    $params[] = "%$searchBar%";
    $types .= "s";
}

// Add category filter
if (!empty($category) && $category !== 'All Categories') {
    $sql .= " AND c.name = ?";
    $params[] = $category;
    $types .= "s";
}

// Add sorting
switch ($sortBy) {
    case 'price_low':
        $sql .= " ORDER BY b.price ASC";
        break;
    case 'price_high':
        $sql .= " ORDER BY b.price DESC";
        break;
    case 'name_asc':
        $sql .= " ORDER BY b.book_name ASC";
        break;
    default:
        $sql .= " ORDER BY b.book_id DESC";
}

// Execute query
if (!empty($params)) {
    $result = selectQuery($conn, $sql, $types, $params);
} else {
    $result = selectQuery($conn, $sql);
}

// Get categories for dropdown
$sqlCat = "SELECT name FROM Categories";
$resultCat = selectQuery($conn, $sqlCat);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Shop | BookSphere</title>
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
                    <a href="profile.php" class="text-decoration-none">Account</a>
                    <a href="cart.php" class="text-decoration-none">
                        <i class="lni lni-cart"></i> Cart
                    </a>
                    <a href="logout.php" class="text-decoration-none text-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Search / Filter Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" placeholder="Search by book name..."
                                    name="searchBar" value="<?= htmlspecialchars($searchBar) ?>">
                                <?php if (!empty($searchBar) || !empty($category) || !empty($sortBy)): ?>
                                    <a href="shop.php" class="btn btn-outline-secondary">Clear</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" name="category" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <?php
                                if ($resultCat->num_rows > 0) {
                                    while ($rowCat = $resultCat->fetch_assoc()) {
                                        $selected = ($category === $rowCat['name']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($rowCat['name']) . "' $selected>"
                                            . htmlspecialchars($rowCat['name']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" name="sort" onchange="this.form.submit()">
                                <option value="">Sort By</option>
                                <option value="price_low" <?= $sortBy === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                                <option value="price_high" <?= $sortBy === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                                <option value="name_asc" <?= $sortBy === 'name_asc' ? 'selected' : '' ?>>Name: A-Z</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display Books -->
        <div class="row g-3">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $discount = (int)($row['discount_percentage'] ?? 0);
                    $finalPrice = $row['price'];

                    if ($discount > 0) {
                        $finalPrice = $finalPrice - ($finalPrice * $discount / 100);
                    }

            ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?= htmlspecialchars($row['image_path']) ?>"
                                        alt="Book cover"
                                        class="rounded mb-3 w-100"
                                        style="height:200px;object-fit:cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded mb-3" style="height:200px;"></div>
                                <?php endif; ?>

                                <h6 class="mb-1"><?= htmlspecialchars($row['book_name']) ?></h6>
                                <small class="text-muted d-block mb-2"><?= htmlspecialchars($row['author_name'] ?? 'Unknown') ?></small>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="mb-2">
                                        <strong class="text-primary">$<?= number_format($finalPrice, 2) ?></strong>
                                        <span style="text-decoration: line-through;"><?= '$' . $row['price'] ?></span>
                                    </div>
                                    <span class="badge bg-success"><?= '%' . $row['discount_percentage'] ?></span>
                                    <!-- <?php if ($row['stock'] > 0): ?>
                                        <span class="badge bg-success">In Stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Out of Stock</span>
                                    <?php endif; ?> -->
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="product.php?book_id=<?= $row['book_id'] ?>" class="btn btn-sm btn-outline-primary w-100">View</a>
                                    <?php if ($row['stock'] > 0): ?>
                                        <form method="POST" action="cart.php" style="width: 100%;">
                                            <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                                <i class="lni lni-cart"></i> Add
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary w-100" disabled>Out of Stock</button>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="col-12"><p class="text-center text-muted">No books found.</p></div>';
            }
            ?>
        </div>
    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>