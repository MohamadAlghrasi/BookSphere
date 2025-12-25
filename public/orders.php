<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Orders | BookSphere</title>
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
            <div>
                <h3 class="mb-0">My Orders</h3>
                <p class="text-muted mb-0">Track your orders status here.</p>
            </div>
            <a href="shop.php" class="btn btn-outline-primary btn-sm">
                <i class="lni lni-shopping-basket"></i> Shop More
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td><strong>#1001</strong></td>
                                <td>2025-12-25</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>$35.00</td>
                                <td class="text-end">
                                    <a href="order_details.php" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#1000</strong></td>
                                <td>2025-12-20</td>
                                <td><span class="badge bg-success">Shipped</span></td>
                                <td>$54.50</td>
                                <td class="text-end">
                                    <a href="order_details.php" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#999</strong></td>
                                <td>2025-12-10</td>
                                <td><span class="badge bg-secondary">Delivered</span></td>
                                <td>$19.99</td>
                                <td class="text-end">
                                    <a href="order_details.php" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Empty state (keep for later if no orders) -->
        <!--
    <div class="text-center py-5">
      <i class="lni lni-package fs-1 text-muted"></i>
      <h5 class="mt-2">No orders yet</h5>
      <p class="text-muted">Start shopping to place your first order.</p>
      <a href="shop.php" class="btn btn-primary">Go to Shop</a>
    </div>
    -->

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>