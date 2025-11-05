<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "event_vibes");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        header("Location: login.php?error=Email and password are required");
        exit;
    }

    // Prepare SQL to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Compare plain text passwords
            if ($password === $user['password']) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_role'] = $user['role']; // 'admin' or 'user'

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit;
            } else {
                header("Location: login.php?error=Incorrect password");
                exit;
            }
        } else {
            header("Location: login.php?error=No user found with this email");
            exit;
        }
        $stmt->close(); // Close statement only if it exists
    } else {
        header("Location: login.php?error=Database error");
        exit;
    }
}

// Close connection only if it's valid
if ($conn) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="register.css">
    <link rel="icon" href="white.png" type="image/x-icon">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="white.png" alt="logo">
                <h3>Event Vibe...✨</h3>
            </div>
            <ul>
                <li class="nav-item" id="home-item">Home</li>
                <li class="nav-item"><a href="event list.php">Events</a></li>
                <li class="nav-item"><a href="contact us.php">Contact us</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <!-- If user is logged in, show Profile section -->
                <li class="nav-item"><a href="profile.php">Profile</a></li>
            <?php else: ?>
                <li class="nav-item"><a href="login.php">Login</a></li>
            <?php endif; ?>
            
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <form action="login.php" method="post">
                <h2>Login</h2>
                <?php
                if (isset($_GET['error'])) {
                    echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
                }
                ?>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your Email" required>
            
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            
                <p><a href="login-forgot.php">Forgot password?</a></p>
                <p>Don't have an account? <a href="register.html">Sign-up</a></p>
                <br><br>
                <input type="submit" value="Login">
            </form>
        <br><br>
    </main>
    <footer>
        <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
    </footer>
</body>
</html>
