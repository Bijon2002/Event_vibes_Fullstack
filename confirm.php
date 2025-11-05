<?php
session_start();
include('db_connection.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer

// Ensure booking_id is provided and is a number
if (!isset($_GET['booking_id']) || !is_numeric($_GET['booking_id'])) {
    die("❌ Invalid booking. Booking ID must be a number.");
}

$booking_id = (int) $_GET['booking_id']; // Convert to integer for safety

// Fetch booking details
$sql = "SELECT b.*, u.first_name, u.last_name, u.email FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        WHERE b.booking_id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("❌ SQL Prepare Error: " . $conn->error);
}

$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $booking = $result->fetch_assoc();
} else {
    die("❌ Booking not found. Please check if the booking ID exists in the database.");
}

// Send confirmation email
$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'event.vibesz@gmail.com'; // Your Gmail address
    $mail->Password = 'mptm udmv iglk ozzi';  // Your Gmail password or app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('event.vibesz@gmail.com', 'Event Vibe');
    $mail->addAddress($booking['email'], $booking['first_name'] . ' ' . $booking['last_name']);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Booking Confirmation - Event Vibe';
    $mail->Body    = "<h1>Booking Confirmation</h1>
                      <p>Dear " . $booking['first_name'] . " " . $booking['last_name'] . ",</p>
                      <p>Your booking with Event Vibe has been confirmed. Here are the details:</p>
                      <table>
                          <tr><th>Booking ID:</th><td>" . $booking['booking_id'] . "</td></tr>
                          <tr><th>Event:</th><td>" . $booking['event_name'] . "</td></tr>
                          <tr><th>Package:</th><td>" . $booking['package_name'] . "</td></tr>
                          <tr><th>Hall:</th><td>" . $booking['hall_name'] . "</td></tr>
                          <tr><th>Catering Type:</th><td>" . $booking['catering_type'] . "</td></tr>
                          <tr><th>Photography:</th><td>" . $booking['photography'] . "</td></tr>
                          <tr><th>Total Cost:</th><td>LKR " . number_format($booking['total_cost'], 2) . "</td></tr>
                          <tr><th>Booking Date:</th><td>" . $booking['created_at'] . "</td></tr>
                      </table>
                      <p>Thank you for booking with us!</p>";

    $mail->send();
    // Email sent successfully
} catch (Exception $e) {
    // Handle email sending error
    echo "❌ Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="white.png" type="image/x-icon">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="confirmd.css">
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <img src="white.png" alt="logo">
            <h3>Event Vibe...✨</h3>
        </div>
        <ul>
            <li class="nav-item"><a href="home.php">Home</a></li>
            <li class="nav-item"><a href="event list.php">Events</a></li>
            <li class="nav-item"><a href="contact us.php">Contact Us</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><a href="profile.php">Profile</a></li>
            <?php else: ?>
                <li class="nav-item"><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
    <div class="confirmation">
        <h1>Booking Confirmation</h1>
        <br>
        <img src="EVENT_VIBES_BOOKING.PNG" alt="Booking Image" style="width: 160px; height: 160px; border-radius: 5px;">
        <h4>Booking ID: <?php echo htmlspecialchars($booking['booking_id']); ?></h4>

      
        <table>
            <tr>
                <th>Thank you for booking:</th>
          
                <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
            </tr>
            <tr>
                <th>Event:</th>
                <td><?php echo htmlspecialchars($booking['event_name']); ?></td>
            </tr>
            <tr>
                <th>Package:</th>
                <td><?php echo htmlspecialchars($booking['package_name']); ?></td>
            </tr>
            <tr>
                <th>Hall:</th>
                <td><?php echo htmlspecialchars($booking['hall_name']); ?></td>
            </tr>
            <tr>
                <th>Catering Type:</th>
                <td><?php echo htmlspecialchars($booking['catering_type']); ?></td>
            </tr>
            <tr>
                <th>Photography:</th>
                <td><?php echo htmlspecialchars($booking['photography']); ?></td>
            </tr>
            <tr>
                <th>Total Cost:</th>
                <td>LKR <?php echo number_format($booking['total_cost'], 2); ?></td>
            </tr>
            <tr>
                <th>Booking Date:</th>
                <td><?php echo htmlspecialchars($booking['created_at']); ?></td>
            </tr>
        </table>
        <div class="confirmation-button">
            <a href="user_dashboard.php" class="btn">view Booked Events</a>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
</footer>

</body>
</html>
