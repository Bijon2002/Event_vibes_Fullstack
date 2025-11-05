<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Category</title>
    <link rel="icon" href="white.png" type="image/x-icon">
    <link rel="stylesheet" href="event list.css">
</head>
<body>
        <!--pre loader               -->
        <div id="preloader">

        </div> 
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
    

            <div class="category-box">
                <h2>BIRTHDAY</h2>
                <img src="birthday.png" alt="">
                <p>"Make birthdays memorable with our tailored packages..."</p>
                <button class="view-details"><a href="Event plans B.php" >View Details</a></button>


            </div>
            <div class="category-box">
                <h2>WEDDINGS</h2>
                <img src="wedding.png" alt="">
                <p>"Exclusive packages to make your wedding unforgettable..."</p>
                <button class="view-details"><a href="Event plans W.php" >View Details</a></button>
            </div>

            <div class="category-box">
                <h2>PUBERTY CEREMONY</h2>
                <img src="pub2.png" alt="">
                <p>"Celebrate the special moments of tradition and culture</p>
                <button class="view-details"><a href="Event plans P.php" >View Details</a></button>
            </div>

   
        </div>
    </main>

    <footer>
        <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
    </footer>

        <!--script for preloader        -->
        <script>
            var loader = document.getElementById("preloader");
    
            window.addEventListener('load', function(load) {
                window.removeEventListener('load', load, false);               
                setTimeout(function(){loader.style.display = 'none'},2000);
              
              },false);
        </script>
</body>
</html>