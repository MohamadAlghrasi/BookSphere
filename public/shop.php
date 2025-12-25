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

        <!-- Search / Filter (UI only for now) -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Search by book name...">
                    </div>

                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>All Categories</option>
                            <option>Fiction</option>
                            <option>Programming</option>
                            <option>Business</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>Sort By</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Top Rated</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Grid (static placeholders for now) -->
        <div class="row g-3">

            <?php for ($i = 0; $i < 8; $i++): ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="bg-light rounded mb-3" style="height:160px;"></div>

                            <h6 class="mb-1">Book Title</h6>
                            <small class="text-muted d-block mb-2">Author Name</small>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>$15.00</strong>
                                <span class="badge bg-success">-10%</span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="product.php" class="btn btn-sm btn-outline-primary w-100">View</a>
                                <button class="btn btn-sm btn-primary w-100">Add</button>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endfor; ?>

        </div>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>