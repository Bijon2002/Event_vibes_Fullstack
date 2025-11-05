<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <main>
        <h1>User Profile</h1>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?>!</p>

        <h3>Profile Information</h3>
        <p><strong>Name:</strong> <?php echo $_SESSION['user_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>

        <h3>Actions</h3>
        <ul>
            <li><a href="edit_profile.php">Edit Profile</a></li>
            <li><a href="user_bookings.php">View My Bookings</a></li>
        </ul>
    </main>
    <footer>
        <p>&copy; 2024 Event Vibe. All Rights Reserved.</p>
    </footer>
</body>
</html>
