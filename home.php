<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Vibe...✨</title>
    
    <link rel="stylesheet" href="home.css">
    <link rel="icon" href="white.png" type="image/x-icon">
</head>
<body>

        <!--pre loader              -->
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
            <h1>Welcome to Event Vibe</h1> 
            <p>Your Preference, Our Priority !</p>
           <div class="search-area">
    <input type="text" id="search-box" class="search-box" placeholder="Search for events...">
    <button id="book-now-btn" class="cta-button">Book Now</button>
</div>

           
            <video src="back.mp4" loop autoplay muted ></video>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
    </footer>

    <script>
        document.getElementById("book-now-btn").addEventListener("click", function() {
            // Get the search query entered by the user
            const query = document.getElementById("search-box").value.toLowerCase().trim();
    
            // Define a mapping of search terms to HTML pages

            
            const eventPages = {
                "wedding": "dummywed.php",
                "birthday": "dummybirth.php",
                "puberty ceremony": "dummypuberty.php",
               
                // Add more events and corresponding pages as needed
            };
    
            // Check if the query matches any of the events
            if (eventPages[query]) {
                // Redirect to the corresponding event page
                window.location.href = eventPages[query];
            } else {
                // Display a message if no matching event is found
                alert("Event not found. Please try searching for 'Wedding', 'Birthday', etc.");
            }
        });
    </script>

    <!--script for preloader            -->
    <script>
        var loader = document.getElementById("preloader");

        window.addEventListener('load', function(load) {
            window.removeEventListener('load', load, false);               
            setTimeout(function(){loader.style.display = 'none'},2000);
          
          },false);
    </script>
</body>
</html>
