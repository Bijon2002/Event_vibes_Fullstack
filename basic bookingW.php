<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Fetch halls from the database
$halls = [];
$sql = "SELECT hall_id, hall_name, capacity, price FROM halls 
        WHERE hall_id IN ('5', '6')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $halls[] = $row;
    }
}

// Fetch catering options from the database
$cateringOptions = [];
$sql = "SELECT catering_id, name, price FROM catering WHERE catering_id IN ('10','11','12')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cateringOptions[] = $row;
    }
}

// Handle booking submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $event_name = $_POST['event_name'];
    $package_name = $_POST['package_name'];
    $hall_name = $_POST['hall_name'];
    $catering_type = $_POST['catering_type'];
    $photography = $_POST['photography'];
    $total_cost = $_POST['total_cost'];
    $created_at = date("Y-m-d H:i:s");

    // Insert booking into database
    $sql = "INSERT INTO bookings (user_id, event_name, package_name, hall_name, catering_type, photography, total_cost, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssis", $user_id, $event_name, $package_name, $hall_name, $catering_type, $photography, $total_cost, $created_at);

    if ($stmt->execute()) {
        // Get the last inserted booking ID
        $booking_id = $stmt->insert_id;
    
        // Redirect to confirm.php with booking_id
        echo "<script>
            alert('Booking successful!');
            window.location.href='confirm.php?booking_id=$booking_id';
        </script>";
        exit();
    }
    

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="white.png" type="image/x-icon">
    <title>Basic Booking Confirmation</title>
    <link rel="stylesheet" href="basic booking.css">
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
            <li class="nav-item" id="home-item"><a href="event list.php">Events</a></li>
            <li class="nav-item"><a href="contact us.php">Contact us</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><a href="profile.php">Profile</a></li>
            <?php else: ?>
                <li class="nav-item"><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
    <div class="booking">
        <h1 id="head">Our Basic Plan</h1>
        <h4 id="sub">Booking Summary</h4>

        <form method="POST" >
            <input type="hidden" name="event_name" value="Wedding">
            <input type="hidden" name="package_name" value="Basic">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="total_cost" id="totalCostInput">
            <input type="hidden" name="hall_name" id="hallNameInput">
            <input type="hidden" name="catering_type" id="cateringTypeInput">
            <input type="hidden" name="photography" id="photographyInput">

            <!-- Dynamically Display Halls -->
            <h2>Choose a Hall:</h2>
            <?php foreach ($halls as $hall): ?>
                <div class="hall-BA">
                    <label>
                        <input type="radio" name="hall" value="<?php echo $hall['price']; ?>" 
                               data-name="<?php echo $hall['hall_name']; ?>" 
                               onclick="updateTotal()"> 
                        Hall: <?php echo $hall['hall_name']; ?> (Capacity: <?php echo $hall['capacity']; ?> Guests, Price: LKR <?php echo number_format($hall['price']); ?>)
                    </label>
                </div>
            <?php endforeach; ?>

            <br><br>

            <!-- Catering Options from Database -->
            <div class="food">
                <h2 id="cat">Catering</h2>
                <?php foreach ($cateringOptions as $catering): ?>
                    <label>
                        <input type="radio" name="catering" value="<?php echo $catering['price']; ?>" 
                               data-name="<?php echo $catering['name']; ?>" 
                               onclick="updateTotal()"> 
                        <?php echo $catering['name']; ?> (LKR <?php echo number_format($catering['price']); ?>)
                    </label>
                    <br>
                <?php endforeach; ?>
            </div>

            <br><br>

            <!-- Photography Option -->
            <h4>Photography (Additional Cost)</h4>
            <label class="checkbox-label" for="photo">
                <input type="checkbox" id="photo" value="20000" onclick="updateTotal()"> Photography: LKR 20,000 for 3 hours
            </label>

            <br><br><br>

            <!-- Total Cost and Confirmation Button -->
            <center>
                <h4>Total Cost<br><span id="totalCost">LKR 0.00</span></h4>
                <button type="submit" class="btn">Confirm</button>
            </center>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
</footer>

<script>
    function updateTotal() {
        let totalCost = 0;

        // Get selected hall price
        let hall = document.querySelector('input[name="hall"]:checked');
        if (hall) {
            totalCost += parseFloat(hall.value);
            document.getElementById("hallNameInput").value = hall.getAttribute("data-name");
        }

        // Get selected catering price
        let catering = document.querySelector('input[name="catering"]:checked');
        if (catering) {
            totalCost += parseFloat(catering.value);
            document.getElementById("cateringTypeInput").value = catering.getAttribute("data-name");
        }

        // Get photography cost
        let photography = document.getElementById('photo');
        if (photography.checked) {
            totalCost += parseFloat(photography.value);
            document.getElementById("photographyInput").value = "Yes";
        } else {
            document.getElementById("photographyInput").value = "No";
        }

        // Update total cost display
        document.getElementById("totalCost").innerText = `LKR ${totalCost.toLocaleString()}`;
        document.getElementById("totalCostInput").value = totalCost;
    }
</script>

</body>
</html>
