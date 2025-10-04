<?php
session_start();

// إذا المستخدم مسجل دخول → Dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: ../views/auth/login.php");
    exit;
} else {
    // غير مسجل دخول → صفحة Login
    header("Location: ../views/auth/login.php");
    exit;
}
?>
