<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Include database connection
include('db_connection.php');

// Check if user ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user's bookings first
    $deleteBookings = $conn->prepare("DELETE FROM bookings WHERE user_id = ?");
    $deleteBookings->bind_param("i", $user_id);
    $deleteBookings->execute();
    $deleteBookings->close();

    // Now delete the user
    $deleteUser = $conn->prepare("DELETE FROM users WHERE id = ?");
    $deleteUser->bind_param("i", $user_id);

    if ($deleteUser->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user!'); window.location.href = 'manage_users.php';</script>";
    }

    // Close statement and connection
    $deleteUser->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid user ID!'); window.location.href = 'manage_users.php';</script>";
}
?>
