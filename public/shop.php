<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

// Get filter parameters
$searchBar = trim($_GET['searchBar'] ?? '');
$category = $_GET['category'] ?? '';
$sortBy = $_GET['sort'] ?? '';

// Build query dynamically
$sql = "SELECT books.book_id, books.book_name, books.price, authors.author_name, categories.name as category_name 
        FROM books 
        LEFT JOIN book_author ON books.book_id = book_author.book_id 
        LEFT JOIN authors ON authors.author_id = book_author.author_id
        LEFT JOIN book_category ON books.book_id = book_category.book_id
        LEFT JOIN categories ON categories.category_id = book_category.category_id
        WHERE 1=1";

$params = [];
$types = "";

// Add search filter
if (!empty($searchBar)) {
    $sql .= " AND books.book_name LIKE ?";
    $params[] = "%$searchBar%";
    $types .= "s";
}

// Add category filter
if (!empty($category) && $category !== 'All Categories') {
    $sql .= " AND categories.name = ?";
    $params[] = $category;
    $types .= "s";
}

// Add sorting
switch ($sortBy) {
    case 'price_low':
        $sql .= " ORDER BY books.price ASC";
        break;
    case 'price_high':
        $sql .= " ORDER BY books.price DESC";
        break;
    case 'top_rated':
        $sql .= " ORDER BY books.rating DESC";
        break;
    default:
        $sql .= " ORDER BY books.book_id DESC";
}

// Execute query
if (!empty($params)) {
    $result = selectQuery($conn, $sql, $types, $params);
} else {
    $result = selectQuery($conn, $sql);
}

// Get categories for dropdown
$sqlCat = "SELECT name FROM categories";
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
                    <a href="wishlist.php" class="text-decoration-none">
                        <i class="lni lni-heart"></i> Wishlist
                    </a>
                    <a href="cart.php" class="text-decoration-none">
                        <i class="lni lni-cart"></i> Cart
                    </a>
                    <a href="orders.php" class="text-decoration-none">Orders</a>
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
                                <option value="top_rated" <?= $sortBy === 'top_rated' ? 'selected' : '' ?>>Top Rated</option>
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
            ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="bg-light rounded mb-3" style="height:160px;"></div>

                                <h6 class="mb-1"><?= htmlspecialchars($row['book_name']) ?></h6>
                                <small class="text-muted d-block mb-2"><?= htmlspecialchars($row['author_name'] ?? 'Unknown') ?></small>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>$<?= htmlspecialchars($row['price']) ?></strong>
                                    <span class="badge bg-success">-10%</span>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="product.php?book_id=<?= $row['book_id'] ?>" class="btn btn-sm btn-outline-primary w-100">View</a>
                                    <form method="POST" action="cart.php" style="width: 100%;">
                                        <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Add</button>
                                    </form>
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