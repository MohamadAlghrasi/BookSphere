<?php
session_start();

require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($password) && !empty($confirmPassword)) {

        if ($password === $confirmPassword) {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, pass) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $hashedPassword);
            $insertResult = $stmt->execute();

            if ($insertResult) {

                $userId = $conn->insert_id;
                $_SESSION['user_id'] = $userId;

                $stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $role = $row['role'];

                if ($role === 'user') {
                    header("Location: ../../public/shop.php");
                    exit;
                } else {
                    header("Location: ../../admin/index.php");
                    exit;
                }
            }
        } else {
            echo "Passwords do not match";
        }
    }
}
