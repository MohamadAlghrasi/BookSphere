<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user's orders
$sqlOrders = "SELECT order_id, total_amount, order_status, created_at 
              FROM orders 
              WHERE user_id = ? 
              ORDER BY created_at DESC";

$resultOrders = selectQuery($conn, $sqlOrders, "i", [$user_id]);
?>
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

        <!-- Success Messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">My Orders</h3>
                <p class="text-muted mb-0">Track your orders status here.</p>
            </div>
            <a href="shop.php" class="btn btn-outline-primary btn-sm">
                <i class="lni lni-shopping-basket"></i> Shop More
            </a>
        </div>

        <?php if ($resultOrders->num_rows > 0): ?>
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

                                <?php
                                $counter = 1;
                                while ($order = $resultOrders->fetch_assoc()):
                                    // Badge color
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
                                    <tr>
                                        <td><strong>#<?= $counter ?></strong></td>

                                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>

                                        <td>
                                            <span class="badge <?= $badgeClass ?>">
                                                <?= htmlspecialchars($displayStatus) ?>
                                            </span>
                                        </td>

                                        <td>$<?= number_format($order['total_amount'], 2) ?></td>

                                        <td class="text-end">
                                            <a href="order_details.php?order_id=<?= $order['order_id'] ?>&n=<?= $counter ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $counter++;
                                endwhile;
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="lni lni-package" style="font-size: 4rem; color: #ccc;"></i>
                    <h5 class="mt-3">No orders yet</h5>
                    <p class="text-muted">Start shopping to place your first order.</p>
                    <a href="shop.php" class="btn btn-primary">Go to Shop</a>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
