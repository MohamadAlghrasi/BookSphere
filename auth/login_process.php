<?php

require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT pass FROM users where email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($result->num_rows === 1) {
            if ($password === $row['pass']) {
                echo "Valid Authentication";
            } else {
                echo "Email or Password Wrong";
            }
        } else {
            echo "Email doesn't exist";
        }
    }
}
