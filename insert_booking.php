<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$event_name = $_POST['event_name'];
$package_name = $_POST['package_name'];
$total_cost = $_POST['total_cost'];
$booking_source = 'insert_booking.php'; // Use the actual update page



$sql = "INSERT INTO bookings (user_id, event_name, package_name, total_cost, source_page) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issds", $user_id, $event_name, $package_name, $total_cost, $booking_source);


if ($stmt->execute()) {
    $_SESSION['message'] = "Booking successful!";
    header("Location: user_dashboard.php");
    exit();
} else {
    $_SESSION['message'] = "Booking failed!";
    header("Location: " . $_SERVER['HTTP_REFERER']); // Go back to previous page
    exit();
}

?>