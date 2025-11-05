<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" href="white.png" type="image/x-icon">
    <link rel="stylesheet" href="contactus.css">
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
                <li class="nav-item"><a href="contactus.php">Contact Us</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a href="profile.php">Profile</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="contact-details">
                <center><h1>Have a question or need assistance with your event?</h1></center>
                <br>
                <p>
                    At Event Vibe, we are committed to making your event planning seamless, stress-free, and truly memorable. Founded on April 23, 2024, by our visionary leader, Mr. Bijon (CEO of Bijon Solutions & Event Vibe), our platform was created with one goal in mind—to provide top-notch event management solutions tailored to your needs.
                </p>
                <br>

                <center><h2>Contact Information</h2></center>
                <div class="contact-info">
                    <p><strong>📧 Email:</strong> event.vibesz@gmail.com</p>
                    <p><strong>📞 Phone:</strong> +94 720172910</p>
                    <p><strong>💬 Live Chat:</strong> Available on our website during business hours</p>
                </div>
            </div>

            <div class="contact-form">
                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <p style="color: green;">Message sent successfully!</p>
                <?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
                    <p style="color: red;">Failed to send message. Please try again.</p>
                <?php endif; ?>

                <form action="contact_process.php" method="post">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>

                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>

                    <label for="mobile">Phone Number (optional)</label>
                    <input type="tel" id="mobile" name="mobile" placeholder="Enter your phone number">

                    <label for="topic">Select Your Topic</label>
                    <select id="topic" name="topic" required>
                        <option value="">-- Please choose an option --</option>
                        <option value="venue-inquiry">Venue Inquiry</option>
                        <option value="booking-assistance">Booking Assistance</option>
                        <option value="pricing-package">Pricing & Package</option>
                        <option value="event-types">Event Types</option>
                        <option value="feedback">Feedback</option>
                        <option value="other">Other</option>
                    </select>

                    <label for="message">Message</label>
                    <textarea name="message" id="message" cols="30" rows="4" placeholder="Describe your inquiry or provide additional details"></textarea>

                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 All rights reserved by <b>Event Vibe</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
    </footer>

    <!-- Preloader Script -->
    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener('load', function(load) {
            window.removeEventListener('load', load, false);
            setTimeout(function() { loader.style.display = 'none' }, 2000);
        }, false);
    </script>

</body>
</html>
