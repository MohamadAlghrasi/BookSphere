<?php
session_start();
require_once __DIR__ . '/../helpers/db_queries.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user info
$sqlUser = "SELECT * FROM users WHERE user_id = ?";
$resultUser = selectQuery($conn, $sqlUser, "i", [$user_id]);
$user = $resultUser->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Validation
    if (empty($name) || empty($email) || empty($phone)) {
        $_SESSION['error_message'] = "Name, email, and phone are required!";
    } else {
        $sqlUpdate = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
        $result = executeQuery($conn, $sqlUpdate, "ssssi", [$name, $email, $phone, $address, $user_id]);

        if ($result) {
            $_SESSION['success_message'] = "Profile updated successfully!";
            header("Location: profile.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to update profile!";
        }
    }
}

// Handle password change
// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changePassword'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verify current password (hashed in DB)
    if (password_verify($currentPassword, $user['pass'])) {

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = "New passwords do not match!";
        } elseif (strlen($newPassword) < 6) {
            $_SESSION['error_message'] = "Password must be at least 6 characters!";
        } else {
            // Hash the new password قبل التخزين
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $sqlUpdatePwd = "UPDATE users SET pass = ? WHERE user_id = ?";
            $result = executeQuery($conn, $sqlUpdatePwd, "si", [$hashedPassword, $user_id]);

            if ($result) {
                $_SESSION['success_message'] = "Password changed successfully!";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to change password!";
            }
        }
    } else {
        $_SESSION['error_message'] = "Current password is incorrect!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Profile | BookSphere</title>
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


        <div class="row g-4">
            <div class="col-lg-8">

                <!-- Edit Profile -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Personal Information</h5>

                        <form method="POST" action="profile.php">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" name="name"
                                        value="<?= htmlspecialchars($user['name']) ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control" name="email"
                                        value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone *</label>
                                    <input type="tel" class="form-control" name="phone"
                                        value="<?= htmlspecialchars($user['phone']) ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control"
                                        value="<?= htmlspecialchars(ucfirst($user['role'])) ?>" disabled>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="2"
                                        placeholder="Enter your address..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" name="updateProfile" class="btn btn-primary">
                                    <i class="lni lni-save"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Change Password</h5>

                        <form method="POST" action="profile.php">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password"
                                        minlength="6" required>
                                    <small class="text-muted">Minimum 6 characters</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password"
                                        minlength="6" required>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" name="changePassword" class="btn btn-warning">
                                    <i class="lni lni-lock"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Quick Links</h5>

                        <div class="d-grid gap-2">
                            <a href="orders.php" class="btn btn-outline-primary">
                                <i class="lni lni-package me-2"></i> My Orders
                            </a>
                            <a href="cart.php" class="btn btn-outline-primary">
                                <i class="lni lni-cart me-2"></i> My Cart
                            </a>
                            <a href="shop.php" class="btn btn-outline-primary">
                                <i class="lni lni-shopping-basket me-2"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>