<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Include database connection
include('db_connection.php');

// Get user ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT first_name, last_name, email, nic FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found!'); window.location.href = 'manage_users.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid user ID!'); window.location.href = 'manage_users.php';</script>";
    exit;
}

// Update user details if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $nic = $_POST['nic'];

    $updateStmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, nic = ? WHERE id = ?");
    $updateStmt->bind_param("ssssi", $first_name, $last_name, $email, $nic, $user_id);

    if ($updateStmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "<script>alert('Error updating user!');</script>";
    }

    $updateStmt->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <img src="white.png" alt="logo">
            <h3>Event Vibe...✨</h3>
        </div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="event_list.php">Events</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="container">
        <h2>Update User</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required>

            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label>NIC:</label>
            <input type="text" name="nic" value="<?php echo $user['nic']; ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2024 All rights reserved by <b>Event Vibes</b></p>
</footer>

</body>
</html>
