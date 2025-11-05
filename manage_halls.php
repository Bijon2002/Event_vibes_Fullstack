<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle the delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_hall_id'])) {
    $hall_id = $_POST['delete_hall_id'];
    
    // Delete hall from the database
    $delete_sql = "DELETE FROM halls WHERE hall_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $hall_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Hall deleted successfully!'); window.location.reload();</script>";
    } else {
        echo "<script>alert('Error deleting hall.');</script>";
    }
}

// Fetch all halls from the database
$sql = "SELECT hall_id, hall_name, capacity, price FROM halls";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Halls</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: skyblue;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: url(adminback.jpg);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            color: white;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: maroon;
            color: white;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-edit {
            background: darkblue;
            color: white;
            text-decoration: none;
            padding: 6px 10px;
            display: inline-block;
        }
        .btn-delete {
            background: red;
            color: white;
        }
        .btn-edit:hover {
            background-color: blue;
        }
        .btn-delete:hover {
            background-color: darkred;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /*-------------------------------------------------------*/
        /* header part */
        .logo {
            display: flex;
            align-items: center;
            color: white;
            font-size: 24px;
            margin-right: 20px;
        }
        .logo img {
            display: flex;
            height: 55px;
            width: 66px;
            margin-right: 1px;
        }
        .logo h3 {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
        }
        header ul {
            display: flex;
            justify-content: flex-end;
            list-style: none;
            margin: 0;
            padding: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        header ul li {
            margin: 0 10px;
        }
        header ul a {
            text-decoration: none;
            color: white;
        }
        header ul li:hover {
            color: yellow;
            cursor: pointer;
            text-decoration: underline;
        }
        header {
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .admin {
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
            <li class="nav-item"><a href="contact us.php">Contact us</a></li>
            <li class="nav-item"><a href="logout.php">Logout</a></li>
            <li class="nav-item"><a href="admin_dashboard.php">Profile</a></li>
            <li class="admin"><b>Hi Admin!</b><img src="circleBijon.png" alt="" height="60px" width="60px"></li>
        </ul>
    </nav>
</header>
<br><br><br><br><br><br>

<div class="container">
    <table>
        <tr>
            <th>Hall Name</th>
            <th>Capacity</th>
            <th>Price (LKR)</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['hall_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                    <td><?php echo number_format($row['price'], 2); ?> LKR</td>
                    <td>
                        <a href="edit_hall.php?hall_id=<?php echo $row['hall_id']; ?>" class="btn btn-edit">Edit</a>
                        <form action="" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this hall?');">
                            <input type="hidden" name="delete_hall_id" value="<?php echo $row['hall_id']; ?>">
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No halls found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
