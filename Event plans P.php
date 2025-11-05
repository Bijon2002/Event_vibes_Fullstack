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
    <title>Event Plans</title>
    <link rel="icon" href="white.png" type="image/x-icon">
    <link rel="stylesheet" href="Eventplans.css">
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
    <h1>Our Pricing Plans</h1>
    <h5>" Your Prefrence,Our Priority... "</h5>


            <div class="category-box" id="basic" >
                
                <img src="basic.png" alt="">
                <h2>Basic Plan</h2>
               
                <p>
                    LKR 130,000 – 150,000
                </p>
                <button class="view-details"><a href="basic bookingP.php">View Details</a></button>


            </div>
            <div class="category-box" id="standard">
                <img src="standard.png" alt="">
                <h2>Standard Plan</h2>
               
                <p>
                    LKR  140,000 – 170,000
                </p>

                <button class="view-details"><a href="standard bookingP.php">View Details</a></button>
            </div>

            <div class="category-box" id="premium">
                <img src="premium.png" alt="">
                <h2>Premuim Plan</h2>
               
                       <p>
                    LKR 170,000 – 190,000
                </p>
                <button class="view-details"><a href="premium bookingP.php">View Details</a></button>
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