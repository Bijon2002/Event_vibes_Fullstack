<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $email = htmlspecialchars($_POST["email"]);
    $mobile = htmlspecialchars($_POST["mobile"]);
    $topic = htmlspecialchars($_POST["topic"]);
    $message = htmlspecialchars($_POST["message"]);

    $adminEmail = "event.vibesz@gmail.com";
    $subject = "New Contact Form Submission: $topic";

    $body = "
        <h2>New Contact Form Submission</h2>
        <p><strong>First Name:</strong> $firstname</p>
        <p><strong>Last Name:</strong> $lastname</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $mobile</p>
        <p><strong>Topic:</strong> $topic</p>
        <p><strong>Message:</strong></p>
        <p>$message</p>
    ";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, "$firstname $lastname");
        $mail->addAddress($adminEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
  
    
       echo "<script>alert('message send successful to event.vibesz@gmail.com');</script>";

        header("Location: home.php");
       
        exit();
    } catch (Exception $e) {
        header("Location: home.php");
        exit();
    }
} else {
    header("Location: home.php");
    exit();
}
?>
