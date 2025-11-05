<?php
session_start();
include 'db_connection.php';

if (!isset($_POST['booking_id'])) {
    $_SESSION['message'] = "Invalid request.";
    header("Location: user_dashboard.php");
    exit();
}

$booking_id = $_POST['booking_id'];
$hall_name = $_POST['hall_name'];
$catering_type = $_POST['catering_type'];
$photography = $_POST['photography'];

// Update the booking in the database
$sql = "UPDATE bookings SET hall_name = ?, catering_type = ?, photography = ? WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $hall_name, $catering_type, $photography, $booking_id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Booking updated successfully!";
} else {
    $_SESSION['message'] = "Error updating booking.";
}

header("Location: user_dashboard.php");
exit();
?>
