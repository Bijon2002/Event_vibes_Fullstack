<?php
// Database connection

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_vibes";

// Establish connection
// my squli : class by php : to interact with mysquli database
// mysqli mysql improved
// create an object for mysqli class by new
// left is passig parameters

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$first_name = $_POST['first-name'];
$last_name = $_POST['last-name'];
$email = $_POST['email'];
$nic = $_POST['NIC'];
$password = $_POST['password']; // Store password as plain text
$card_name = $_POST['card-name'];
$card_number = $_POST['card-number'];
$expiry_date = $_POST['expiry-date'];
$cvv = $_POST['CVV'];

// Check for duplicate NIC or email
$check_query = "SELECT * FROM users WHERE email = '$email' OR nic = '$nic'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    echo "Error: User with this NIC or email already exists.";
} else {
    // Insert data into the database
    $sql = "INSERT INTO users (first_name, last_name, email, nic, password, card_name, card_number, expiry_date, cvv)
            VALUES ('$first_name', '$last_name', '$email', '$nic', '$password', '$card_name', '$card_number', '$expiry_date', '$cvv')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        header("Location: login.php"); // Redirect to login page
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
