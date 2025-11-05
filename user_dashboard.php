<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

// Get logged-in user ID
$user_id = $_SESSION['user_id'];

// Fetch user's bookings
$sql = "SELECT booking_id, event_name, package_name, total_cost FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="icon" href="white.png" type="image/x-icon">
    <link rel="stylesheet" href="user_dashboard.css">

    <style>
        body {
            background-image: url(adminback.jpg);
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }
        .booking-container {
            display: flex;
            flex-wrap: wrap;  
            justify-content: center; 
            gap: 20px;
            padding: 20px;
        }
        .booking-card {
            background: rgba(255, 255, 255, 0.9);
            width: 280px;
            height: 300px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .booking-card h3 {
            color: maroon;
            font-size: 20px;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 5px;
        }
        .btn-delete {
            background: red;
            color: white;
        }
        .btn-delete:hover {
            background-color: darkred;
            transform: scale(1.1);
        }
        nav h1 {
            color: yellow;
        }
        nav h3 {
            color: white;
        }
        
        /* Floating Chatbot Button */
        .chatbot-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        .chatbot-button:hover {
            background-color: #0056b3;
        }

        /* Chatbot Container */
        .chat-container {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 300px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            display: none;
            flex-direction: column;
            overflow: hidden;
        }

        /* Chat Header */
        .chat-header {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        /* Chat Messages */
        .chat-messages {
            height: 250px;
            overflow-y: auto;
            padding: 10px;
            font-size: 14px;
        }

        /* Chat Input */
        .chat-input {
            display: flex;
            border-top: 1px solid #ccc;
        }

        .chat-input input {
            flex: 1;
            padding: 8px;
            border: none;
            outline: none;
        }

        .chat-input button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px;
            cursor: pointer;
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
            <li><a href="home.php">Home</a></li>
            <li><a href="event list.php">Events</a></li>
            <li><a href="contact us.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <br>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <h3>Your Booked Events</h3>
    </nav>
</header>

<div class="container">
    <div class="booking-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="booking-card">
                    <h3><?php echo htmlspecialchars($row['event_name']); ?></h3>
                  <center>  <img src="EVENT_VIBES_BOOKING.PNG" alt="Booking Image" style="width: 100px; height: 100px; border-radius: 5px;"></center>
                    <p><strong>Package:</strong> <?php echo htmlspecialchars($row['package_name']); ?></p>
                    <p><strong>Cost:</strong> <?php echo number_format($row['total_cost'], 2); ?> LKR</p>        
                    <form action="delete_booking.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                        <button type="submit" class="btn btn-delete">Cancel Booking</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Floating Chatbot Button -->
<button class="chatbot-button" onclick="toggleChat()">💬</button>

<!-- Chatbot Window -->
<div class="chat-container" id="chatContainer">
    <div class="chat-header">
        Event Vibe Chatbot
        <span style="float: right; cursor: pointer;" onclick="toggleChat()">✖</span>
    </div>
    <div class="chat-messages" id="chatMessages"></div>
    <div class="chat-input">
        <input type="text" id="chatInput" placeholder="Ask something...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
    function toggleChat() {
        let chatBox = document.getElementById("chatContainer");
        chatBox.style.display = (chatBox.style.display === "none" || chatBox.style.display === "") ? "flex" : "none";
    }

    async function sendMessage() {
    let userInput = document.getElementById("chatInput").value.trim();
    let chatMessages = document.getElementById("chatMessages");

    if (!userInput) return;

    chatMessages.innerHTML += `<div><strong>You:</strong> ${userInput}</div>`;
    document.getElementById("chatInput").value = "";

    try {
        let response = await fetch("chatbot.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ message: userInput })
        });

        if (!response.ok) throw new Error("Server error.");

        let result = await response.json();
        let botReply = result.reply || "No response from AI.";

        chatMessages.innerHTML += `<div><strong>Bot:</strong> ${botReply}</div>`;
    } catch (error) {
        chatMessages.innerHTML += `<div style="color: red;"><strong>Error:</strong> ${error.message}</div>`;
    }

    chatMessages.scrollTop = chatMessages.scrollHeight;
}


</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
