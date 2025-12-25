<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Cart | BookSphere</title>
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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">My Cart</h3>
            <a href="shop.php" class="btn btn-outline-primary btn-sm">
                <i class="lni lni-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th style="width:140px;">Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th style="width:60px;"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- Item 1 -->
                                    <tr>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                <div class="bg-light rounded" style="width:60px;height:80px;"></div>
                                                <div>
                                                    <strong>Book Title</strong>
                                                    <div class="text-muted small">Author Name</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <input type="number" class="form-control" min="1" value="1">
                                        </td>

                                        <td>$15.00</td>
                                        <td><strong>$15.00</strong></td>

                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-danger" title="Remove">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Item 2 -->
                                    <tr>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                <div class="bg-light rounded" style="width:60px;height:80px;"></div>
                                                <div>
                                                    <strong>Book Title</strong>
                                                    <div class="text-muted small">Author Name</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <input type="number" class="form-control" min="1" value="2">
                                        </td>

                                        <td>$10.00</td>
                                        <td><strong>$20.00</strong></td>

                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-danger" title="Remove">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button class="btn btn-outline-secondary">
                                Update Cart
                            </button>
                            <button class="btn btn-outline-danger">
                                Clear Cart
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Order Summary</h5>

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

                        <a href="checkout.php" class="btn btn-primary w-100">
                            Proceed to Checkout
                        </a>

                        <small class="text-muted d-block mt-2">
                            *Checkout page will be built next.
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>