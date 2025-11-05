<?php
if (!isset($_GET['booking_id'])) {
    header("Location: user_dashboard.php");
    exit();
}
$booking_id = $_GET['booking_id'];
echo "Booking ID: $booking_id";  // Debugging output
?>