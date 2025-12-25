<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Checkout | BookSphere</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <!-- Header -->
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

        <div class="mb-3">
            <h3 class="mb-0">Checkout</h3>
            <p class="text-muted mb-0">Fill your shipping info and confirm your order.</p>
        </div>

        <div class="row g-4">

            <!-- Shipping Form -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3">Shipping Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" placeholder="Phone number">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Email address">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" placeholder="City">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="Street, building, etc.">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select">
                                    <option selected>Cash on Delivery</option>
                                    <option>Credit Card (later)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Notes (optional)</label>
                                <input type="text" class="form-control" placeholder="Any notes?">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Order Summary</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Items</span>
                            <strong>2</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <strong>$35.00</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <strong>$0.00</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Total</span>
                            <strong>$35.00</strong>
                        </div>

                        <button class="btn btn-primary w-100">
                            Place Order
                        </button>

                        <small class="text-muted d-block mt-2">
                            *This is UI only for now. Backend will be added later.
                        </small>
                    </div>
                </div>

                <!-- Small tip box -->
                <div class="alert alert-light border mt-3 mb-0">
                    <div class="small">
                        After placing the order, user will see it in <strong>Orders</strong>.
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>