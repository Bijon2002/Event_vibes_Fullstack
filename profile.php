<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Redirect based on role
if ($_SESSION['user_role'] === 'admin') {
    header("Location: admin_dashboard.php");
} else {
    header("Location: user_dashboard.php");
}
exit;
?>
