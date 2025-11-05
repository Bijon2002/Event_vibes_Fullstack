<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include 'db_connection.php';

// Fetch data from the database by joining relevant tables
$sql = "
    SELECT b.booking_id, b.event_name, b.package_name, b.hall_name, b.catering_type, b.photography, b.total_cost, 
           b.created_at, c.name AS name, c.price AS catering_price, 
           p.name AS package_name, p.min_price, p.max_price,
           u.first_name, u.last_name, u.email, u.nic
    FROM bookings b
    JOIN catering c ON b.catering_type = c.catering_id
    JOIN packages p ON b.package_name = p.name
    JOIN users u ON b.user_id = u.id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages</title>
    <style>
        body {
            background-image: url(adminback.jpg);
            font-family: Arial, sans-serif;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        td {
            background-color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        td a {
            color: #007BFF;
            text-decoration: none;
        }
        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2 style="text-align: center; color: #333;">Manage Packages and Bookings</h2>

<table>
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Event Name</th>
            <th>Package Name</th>
            <th>Hall Name</th>
            <th>Catering Type</th>
            <th>Photography</th>
            <th>Total Cost</th>
            <th>Created At</th>
            <th>Catering Name</th>
            <th>Catering Price</th>
            <th>Package Min Price</th>
            <th>Package Max Price</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>User NIC</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Check if there are any results
        if ($result->num_rows > 0) {
            // Loop through each row and display it
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['booking_id']}</td>
                        <td>{$row['event_name']}</td>
                        <td>{$row['package_name']}</td>
                        <td>{$row['hall_name']}</td>
                        <td>{$row['catering_type']}</td>
                        <td>{$row['photography']}</td>
                        <td>LKR {$row['total_cost']}</td>
                        <td>{$row['created_at']}</td>
                        <td>{$row['name']}</td>
                        <td>LKR {$row['catering_price']}</td>
                        <td>LKR {$row['min_price']}</td>
                        <td>LKR {$row['max_price']}</td>
                        <td>{$row['first_name']} {$row['last_name']}</td>
                        <td><a href='mailto:{$row['email']}'>{$row['email']}</a></td>
                        <td>{$row['nic']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='15'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
