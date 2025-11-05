<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['booking_id'])) {
    $_SESSION['message'] = "Invalid request.";
    header("Location: user_dashboard.php");
    exit();
}

$booking_id = $_GET['booking_id'];

// Fetch booking details
$sql = "SELECT event_name, package_name FROM bookings WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    $_SESSION['message'] = "Booking not found.";
    header("Location: user_dashboard.php");
    exit();
}

$event_name = strtolower(str_replace(" ", "", $booking['event_name'])); // Convert to lowercase & remove spaces
$package_name = strtolower(str_replace(" ", "", $booking['package_name'])); // Convert to lowercase & remove spaces

// Define the mapping of event types and package names to the respective update pages
$update_pages = [
    "birthdaypremium" => "premiumPlanB.php",
    "birthdaystandard" => "standardPlanB.php",
    "birthdaybasic" => "basicPlanB.php",
    "weddingpremium" => "premiumPlanW.php",
    "weddingstandard" => "standardPlanW.php",
    "weddingbasic" => "basicPlanW.php",
    // Add more mappings if needed
];

$key = $event_name . $package_name; // Create a key like "birthdaypremium"

if (array_key_exists($key, $update_pages)) {
    // Redirect user to the correct page with booking ID
    header("Location: " . $update_pages[$key] . "?booking_id=" . $booking_id);
    exit();
} else {
    $_SESSION['message'] = "Invalid package selection.";
    header("Location: user_dashboard.php");
    exit();
}
?>
