<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if hall_id is provided
if (!isset($_GET['hall_id'])) {
    header("Location: manage_halls.php");
    exit();
}

$hall_id = $_GET['hall_id'];

// Fetch hall details
$sql = "SELECT * FROM halls WHERE hall_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hall_id);
$stmt->execute();
$result = $stmt->get_result();
$hall = $result->fetch_assoc();

if (!$hall) {
    echo "Hall not found!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hall_name = $_POST['hall_name'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];

    // Update the hall details in the database
    $update_sql = "UPDATE halls SET hall_name=?, capacity=?, price=? WHERE hall_id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sidi", $hall_name, $capacity, $price, $hall_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Hall updated successfully!'); window.location='manage_halls.php';</script>";
    } else {
        echo "Error updating hall: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hall</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 50px;
            background-image: url(adminback.jpg);
        }
        .container {
            width: 40%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: maroon;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: maroon;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            font-weight: bold;
        }
        button:hover {
            background-color: darkred;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: white;
            background-color: gray;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        a:hover {
            background-color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Hall</h2>
        <form method="POST">
            <label>Hall Name:</label>
            <input type="text" name="hall_name" value="<?php echo htmlspecialchars($hall['hall_name']); ?>" required>

            <label>Capacity:</label>
            <input type="number" name="capacity" value="<?php echo $hall['capacity']; ?>" required>

            <label>Price (LKR):</label>
            <input type="number" name="price" value="<?php echo $hall['price']; ?>" required>

            <button type="submit">Update Hall</button>
            <a href="manage_halls.php">Cancel</a>
        </form>
    </div>
</body>
</html>
