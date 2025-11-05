<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $user_id = $_SESSION['user_id']; // Ensuring the user can only delete their own bookings

    // Delete the booking that belongs to the logged-in user
    $sql = "DELETE FROM bookings WHERE booking_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Booking deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting booking.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to user dashboard
    header("Location: user_dashboard.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: user_dashboard.php");
    exit();
}
?>
