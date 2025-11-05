<?php
require 'vendor/autoload.php'; // Load QR code library (use composer to install)

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (!isset($_GET['booking_id'])) {
    die("Invalid request.");
}

$booking_id = $_GET['booking_id'];
$qrData = "EventVibe Booking ID: $booking_id";

$qrCode = QrCode::create($qrData)
    ->setSize(200)
    ->setMargin(10)
    ->setWriter(new PngWriter());

header('Content-Type: image/png');
echo $qrCode->writeString();
?>
