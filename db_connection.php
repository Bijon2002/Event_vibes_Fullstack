<?php
// Database connection configuration
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "event_vibes"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
