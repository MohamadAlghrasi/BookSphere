<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle Add to Cart from shop.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = (int)$_POST['book_id'];

    if ($book_id > 0) {
        // Check if book already in cart (UNIQUE constraint handles this)
        $sqlCheck = "SELECT cart_id, quantity FROM Cart WHERE user_id = ? AND book_id = ? LIMIT 1";
        $resultCheck = selectQuery($conn, $sqlCheck, "ii", [$user_id, $book_id]);

        if ($resultCheck && $resultCheck->num_rows > 0) {
            // Update quantity
            $row = $resultCheck->fetch_assoc();
            $newQty = (int)$row['quantity'] + 1;

            $sqlUpdate = "UPDATE Cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
            executeQuery($conn, $sqlUpdate, "iii", [$newQty, (int)$row['cart_id'], $user_id]);
        } else {
            // Insert new cart item
            $sqlInsert = "INSERT INTO Cart (user_id, book_id, quantity) VALUES (?, ?, 1)";
            executeQuery($conn, $sqlInsert, "ii", [$user_id, $book_id]);
        }

        $_SESSION['success_message'] = "Book added to cart!";
    }

    header("Location: cart.php");
    exit();
}

// Handle Clear Cart
if (isset($_POST['clearBtn'])) {
    $sqlClear = "DELETE FROM Cart WHERE user_id = ?";
    $result = executeQuery($conn, $sqlClear, "i", [$user_id]);
    if ($result) {
        $_SESSION['success_message'] = "Cart cleared successfully!";
        header("Location: cart.php");
        exit();
    }
}

// Handle Delete Single Item
if (isset($_POST['deleteItem'])) {
    $cart_id = (int)$_POST['cart_id'];
    $sqlDelete = "DELETE FROM Cart WHERE cart_id = ? AND user_id = ?";
    $result = executeQuery($conn, $sqlDelete, "ii", [$cart_id, $user_id]);
    if ($result) {
        $_SESSION['success_message'] = "Item removed from cart!";
        header("Location: cart.php");
        exit();
    }
}

// Handle Update Quantity
if (isset($_POST['updateCart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $cart_id => $quantity) {
            $cart_id = (int)$cart_id;
            $quantity = (int)$quantity;
            if ($quantity > 0) {
                $sqlUpdate = "UPDATE Cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
                executeQuery($conn, $sqlUpdate, "iii", [$quantity, $cart_id, $user_id]);
            }
        }
        $_SESSION['success_message'] = "Cart updated successfully!";
        header("Location: cart.php");
        exit();
    }
}

// Get Cart Items with book details
$sqlCart = "SELECT c.cart_id, c.quantity, b.book_id, b.book_name, b.price, 
            a.author_name, i.image_path
            FROM Cart c
            JOIN Books b ON c.book_id = b.book_id
            LEFT JOIN Book_Author ba ON b.book_id = ba.book_id
            LEFT JOIN Authors a ON a.author_id = ba.author_id
            LEFT JOIN Images i ON b.book_id = i.book_id AND i.is_main = 1
            WHERE c.user_id = ?";

$resultCart = selectQuery($conn, $sqlCart, "i", [$user_id]);

// Calculate totals
$subtotal = 0;
$cartItems = [];
if ($resultCart->num_rows > 0) {
    while ($row = $resultCart->fetch_assoc()) {
        $cartItems[] = $row;
        $subtotal += $row['price'] * $row['quantity'];
    }
}

$shipping = 0;
$total = $subtotal + $shipping;

?>
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
                    <a href="cart.php" class="text-decoration-none"><i class="lni lni-cart"></i> Cart</a>
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
            <h3 class="mb-0">My Cart</h3>
            <a href="shop.php" class="btn btn-outline-primary btn-sm">
                <i class="lni lni-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <?php if (count($cartItems) > 0): ?>
            <form method="POST" action="cart.php">
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
                                            <?php foreach ($cartItems as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex gap-3 align-items-center">
                                                            <?php if (!empty($item['image_path'])): ?>
                                                                <img src="<?= htmlspecialchars($item['image_path']) ?>" 
                                                                     alt="Book cover" 
                                                                     style="width:60px;height:80px;object-fit:cover;" 
                                                                     class="rounded">
                                                            <?php else: ?>
                                                                <div class="bg-light rounded" style="width:60px;height:80px;"></div>
                                                            <?php endif; ?>
                                                            <div>
                                                                <strong><?= htmlspecialchars($item['book_name']) ?></strong>
                                                                <div class="text-muted small"><?= htmlspecialchars($item['author_name'] ?? 'Unknown') ?></div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <input type="number" class="form-control" min="1"
                                                            name="quantities[<?= $item['cart_id'] ?>]"
                                                            value="<?= $item['quantity'] ?>">
                                                    </td>

                                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                                    <td><strong>$<?= number_format($item['price'] * $item['quantity'], 2) ?></strong></td>

                                                    <td class="text-end">
                                                        <button type="submit" name="deleteItem" value="1"
                                                            class="btn btn-sm btn-outline-danger" title="Remove"
                                                            onclick="return confirm('Remove this item?')">
                                                            <i class="lni lni-trash-can"></i>
                                                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button type="submit" name="updateCart" class="btn btn-outline-secondary">
                                        Update Cart
                                    </button>
                                    <button type="submit" name="clearBtn" class="btn btn-outline-danger"
                                        onclick="return confirm('Clear entire cart?')">
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
                                    <strong>$<?= number_format($subtotal, 2) ?></strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <strong>$<?= number_format($shipping, 2) ?></strong>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>Total</span>
                                    <strong>$<?= number_format($total, 2) ?></strong>
                                </div>

                                <a href="checkout.php" class="btn btn-primary w-100">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="lni lni-cart" style="font-size: 4rem; color: #ccc;"></i>
                    <h5 class="mt-3">Your cart is empty</h5>
                    <p class="text-muted">Add some books to get started!</p>
                    <a href="shop.php" class="btn btn-primary">Browse Books</a>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>