<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if catering_id is provided
if (!isset($_GET['catering_id'])) {
    header("Location: manage_catering.php");
    exit();
}

$catering_id = $_GET['catering_id'];

// Fetch catering details
$sql = "SELECT * FROM catering WHERE catering_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $catering_id);
$stmt->execute();
$result = $stmt->get_result();
$catering = $result->fetch_assoc();

if (!$catering) {
    echo "Catering service not found!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $catering_name = $_POST['name'];
    $price = $_POST['price'];

    // Update the catering details in the database
    $update_sql = "UPDATE catering SET name=?, price=? WHERE catering_id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdi", $catering_name, $price, $catering_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Catering updated successfully!'); window.location='manage_catering.php';</script>";
    } else {
        echo "Error updating catering: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catering</title>
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
        <h2>Edit Catering Service</h2>
        <form method="POST">
            <label>Catering Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($catering['name']); ?>" required>

            <label>Price (LKR):</label>
            <input type="number" name="price" value="<?php echo $catering['price']; ?>" required>

            <button type="submit">Update Catering</button>
            <a href="manage_catering.php">Cancel</a>
        </form>
    </div>
</body>
</html>
