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
                        <h3 class="mb-1">Book Title</h3>
                        <p class="text-muted mb-2">by <strong>Author Name</strong></p>

                        <!-- Rating (UI only) -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star"></i>
                            </div>
                            <small class="text-muted">(4.0)</small>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <h4 class="mb-0">$15.00</h4>
                            <span class="badge bg-success">-10%</span>
                            <small class="text-muted text-decoration-line-through">$16.50</small>
                        </div>

                        <p class="mb-4">
                            Simple description about the book. Later this will come from the database.
                            Keep it short and clear for now.
                        </p>

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
                                    <strong>Programming</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Stock</small>
                                    <strong>In Stock</strong>
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

                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <strong>User Name</strong>
                        <small class="text-muted">2025-12-25</small>
                    </div>
                    <div class="mb-2">
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star"></i>
                        <i class="lni lni-star"></i>
                    </div>
                    <p class="mb-0">Nice book, simple and useful.</p>
                </div>

                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between">
                        <strong>User Name</strong>
                        <small class="text-muted">2025-12-20</small>
                    </div>
                    <div class="mb-2">
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star"></i>
                    </div>
                    <p class="mb-0">Great quality, fast delivery.</p>
                </div>

            </div>
        </div>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>