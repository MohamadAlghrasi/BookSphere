<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$order_id = (int)($_GET['order_id'] ?? 0);
$counterNumber = (int)($_GET['n'] ?? 0); // ✅ counter from orders page

if ($order_id <= 0) {
    header("Location: orders.php");
    exit();
}

// Get order details
$sqlOrder = "SELECT o.*, u.name, u.email, u.phone, u.address 
             FROM orders o
             JOIN users u ON o.user_id = u.user_id
             WHERE o.order_id = ? AND o.user_id = ?";
$resultOrder = selectQuery($conn, $sqlOrder, "ii", [$order_id, $user_id]);

if ($resultOrder->num_rows === 0) {
    $_SESSION['error_message'] = "Order not found!";
    header("Location: orders.php");
    exit();
}

$order = $resultOrder->fetch_assoc();

// Get order items from Book_Order table
$sqlItems = "SELECT bo.*, b.book_name, b.isbn, a.author_name 
             FROM Book_Order bo
             JOIN Books b ON bo.book_id = b.book_id
             LEFT JOIN Book_Author ba ON b.book_id = ba.book_id
             LEFT JOIN Authors a ON ba.author_id = a.author_id
             WHERE bo.order_id = ?";
$resultItems = selectQuery($conn, $sqlItems, "i", [$order_id]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Order Details | BookSphere</title>
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
            <h3 class="mb-0">
                Order #<?= ($counterNumber > 0) ? $counterNumber : $order['order_id'] ?>
            </h3>

            <a href="orders.php" class="btn btn-outline-secondary btn-sm">
                <i class="lni lni-arrow-left"></i> Back to Orders
            </a>
        </div>

        <div class="row g-4">
            <!-- Order Info -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Order Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Order Date</small>
                                <strong><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status</small>

                                <?php
                                $badgeClass = 'bg-secondary';
                                if ($order['order_status'] === 'pending') {
                                    $badgeClass = 'bg-warning text-dark';
                                } elseif ($order['order_status'] === 'shipped') {
                                    $badgeClass = 'bg-success';
                                } elseif ($order['order_status'] === 'cancelled') {
                                    $badgeClass = 'bg-danger';
                                }
                                $displayStatus = ucfirst($order['order_status']);
                                ?>

                                <span class="badge <?= $badgeClass ?>">
                                    <?= htmlspecialchars($displayStatus) ?>
                                </span>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Customer Name</small>
                                <strong><?= htmlspecialchars($order['name']) ?></strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Phone</small>
                                <strong><?= htmlspecialchars($order['phone']) ?></strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Email</small>
                                <strong><?= htmlspecialchars($order['email']) ?></strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Payment Method</small>
                                <strong>Cash on Delivery</strong>
                            </div>

                            <div class="col-12">
                                <small class="text-muted d-block">Delivery Address</small>
                                <strong><?= htmlspecialchars($order['address'] ?? 'Not provided') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Order Items</h5>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($item = $resultItems->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong><?= htmlspecialchars($item['book_name']) ?></strong>
                                                    <div class="text-muted small">
                                                        <?= htmlspecialchars($item['author_name'] ?? 'Unknown Author') ?>
                                                    </div>
                                                    <?php if (!empty($item['isbn'])): ?>
                                                        <div class="text-muted small">
                                                            ISBN: <?= htmlspecialchars($item['isbn']) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="text-center"><?= (int)$item['quantity'] ?></td>
                                            <td class="text-end">$<?= number_format((float)$item['price'], 2) ?></td>
                                            <td class="text-end">
                                                <strong>
                                                    $<?= number_format(((float)$item['price'] * (int)$item['quantity']), 2) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Order Summary</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <strong>$<?= number_format((float)$order['total_amount'], 2) ?></strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <strong class="text-success">Free</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-0">
                            <span><strong>Total</strong></span>
                            <strong class="text-primary fs-5">
                                $<?= number_format((float)$order['total_amount'], 2) ?>
                            </strong>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>