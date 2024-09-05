<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

if ($_SESSION['role_id'] == 1) {
    // Redirect to admin dashboard
    header("Location: admin_dashboard.php");
    exit();
} else {
    // Redirect to user dashboard
    header("Location: user_dashboard.php");
    exit();
}
?>
