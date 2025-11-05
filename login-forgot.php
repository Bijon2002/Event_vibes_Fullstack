<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
                <li class="nav-item"><a href="home.php">Home</a></li>
                <li class="nav-item"><a href="event_list.php">Events</a></li>
                <li class="nav-item" id="home-item">Login</li>
                <li class="nav-item"><a href="Event plans.php">Plans</a></li>
                <li class="nav-item"><a href="contact us.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <br>
        <br> 
        <br>
        <div class="container">
            <form id="reset-form">
                <center><h2>Reset Password</h2></center>
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter your Email" required>
                <br>
                <input type="button" value="Send Code" id="send-code-btn">
            </form>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </main>
    <footer>
        <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
    </footer>

    <!-- EmailJS Library -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3.11.0/dist/email.min.js"></script>

    <script>
        // Initialize EmailJS with your Public Key
        emailjs.init('Kgcaa9VcB2DJXwQRz'); // Replace 'YOUR_PUBLIC_KEY' with the actual EmailJS Public Key
        
        document.getElementById('send-code-btn').addEventListener('click', function () {
            const email = document.getElementById('email').value;
        
            if (!email) {
                alert("Please enter a valid email address.");
                return;
            }
        
            // Generate a 6-digit reset code
            const resetCode = Math.floor(100000 + Math.random() * 900000);
        
            // Define template parameters
            const templateParams = {
                email: email, // Maps to {{email}} in EmailJS template
                code: resetCode // Maps to {{code}} in EmailJS template
            };
        
            // Send email using EmailJS
            emailjs.send('service_pupxss9', 'template_pkcnwm7', templateParams) // Replace with actual IDs
                .then(function (response) {
                    console.log('SUCCESS!', response.status, response.text);
                    alert('Reset code sent to your email!');
                })
                .catch(function (error) {
                    console.error('FAILED...', error);
                    alert(`Error: ${error.text || 'Failed to send reset code. Please try again.'}`);
                });
        });
    </script>
</body>
</html>
