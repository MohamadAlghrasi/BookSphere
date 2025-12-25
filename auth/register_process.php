<?php
session_start();
?>
<?php


require_once '../config/db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (
        !empty($name) &&
        !empty($email) &&
        !empty($phone) &&
        !empty($password) &&
        !empty($confirmPassword)
    ) {
        if ($password === $confirmPassword) {
            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, pass) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $password);
            $insertResult = $stmt->execute();
            // check the role to redirect
            $userId = $conn->insert_id;
            $stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result-> fetch_assoc();
            $role = $row['role'];
            if ($insertResult) {
                if ($role === 'user') {
                    header("location: ../index.php");
                    exit();
                } else {
                    header("location: admin.php");
                    exit();
                }
            }
            $_SESSION['user_id'] = $userId;
        }
    }
}
