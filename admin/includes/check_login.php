<?php
session_start();
echo var_dump($_SESSION['user_id']);
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}
