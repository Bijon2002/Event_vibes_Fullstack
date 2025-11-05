<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit;
}

// Include database connection
include('db_connection.php');

// Fetch users (excluding sensitive details)
$sql = "SELECT id, first_name, last_name, email, nic FROM users WHERE role != 'admin'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Users</title>
    <link rel="icon" href="white.png" type="image/x-icon">
    <link rel="stylesheet" href="admin_dashboard.css">
    <style>
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .user-table th, .user-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .user-table th {
            background-color: #4CAF50;
            color: white;
        }
      
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .update-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 3px;
            font-size: 14px;
        }
        .update-btn {
            background-color: #007bff;
            color: white;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
    </style>
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
            <li class="nav-item"><a href="admin_dashboard.php">Profile</a></li>
            <li class="nav-item"><a href="logout.php">Logout</a></li>
            <li class="admin"><b>Hi Admin!</b> <img src="circleBijon.png" alt="" height="60px" width="60px"></li>
        </ul>
    </nav>
</header>

<main>
    <div class="container">
        <h2>Manage Users</h2>
        
        <table class="user-table">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>NIC</th>
                <th>Actions</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["first_name"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["last_name"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["nic"]) . '</td>';
                    echo '<td class="action-buttons">';
                    echo '<a href="update_user.php?id=' . $row["id"] . '" class="update-btn">Update</a>';
                    echo '<a href="delete_user.php?id=' . $row["id"] . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No users found.</td></tr>';
            }

            // Close connection
            $conn->close();
            ?>
        </table>
    </div>
</main>

<footer>
    <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
</footer>

<script>
    var loader = document.getElementById("preloader");
    window.addEventListener('load', function(load) {
        window.removeEventListener('load', load, false);               
        setTimeout(function() { loader.style.display = 'none' }, 2000);
    }, false);
</script>

</body>
</html>
