<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin pannel</title>
    <link rel="icon" href="white.png" type="image/x-icon">
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>


    
        <!--pre loader               -->
        <div id="preloader">

        </div> 

        <style>
            .nav-item
            {
                padding-top: 30px;
                padding-left: 50px;
            }
        </style>
    <header>
        <nav>
            <div class="logo">
                <img src="white.png" alt="logo">
                <h3>Event Vibe...✨</h3>
            </div>
   
            <ul>

          
            <li class="nav-item"><a href="home.php">Home</a></li>
                <li class="nav-item"><a href="event list.php">Events</a></li>
                <li class="nav-item"><a href="logout.php">Logout</a></li>
                <li class="nav-item"><a href="event plans.php">Plans</a></li>
                <li class="nav-item"><a href="contact us.php">Contact us</a></li>
               
                <li class="admin"><b>Hi Admin !   </b><img src="circleBijon.png" alt="" height="60px" width="60px"></li>
           
                
            </ul>
               
               
            </ul>
            
        </nav>
    </header>

   
    <main>

   
        <div class="container">
    
        
        <div class="category-box">
    <h2><img src="cat0.webp" alt="Manage Catering" width="40" height="60"> Manage-Catering</h2>
    <button class="view-details"><a href="manage_catering.php">Admin Go</a></button>
</div>

<div class="category-box">
    <h2><img src="hallm.webp" alt="Manage Halls" width="40" height="60"> Manage-Halls</h2>
    <button class="view-details"><a href="manage_halls.php">Admin Go</a></button>
</div>

<div class="category-box">
    <h2><img src="group.avif" alt="Manage Users" width="40" height="60"> Manage-Users</h2>
    <button class="view-details"><a href="manage_users.php">Admin Go</a></button>
</div>

<div class="category-box">
    <h2><img src="1.webp" alt="Manage Packages" width="40" height="60"> View-All-Details</h2>
    <button class="view-details"><a href="manage_package.php">Admin Go</a></button>
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