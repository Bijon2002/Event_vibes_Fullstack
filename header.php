<?php
// Start the session only if it is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <nav>
        <div class="logo">
            <img src="blue.png" alt="logo">
            <h3>Event Vibe...✨</h3>
     


        </div>
        <ul>
            <li class="nav-item" id="home-item"><a href="home.php">Home</a></li>
            <li class="nav-item"><a href="event_list.php">Events</a></li>
            <li class="nav-item"><a href="event plans.php">Plans</a></li>
            <li class="nav-item"><a href="contact.php">Contact us</a></li>
            
            <!-- Dynamic content -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php">Logout</a>
                </li>
            <?php elseif (isset($_SESSION['admin_id'])): ?>
                <li class="nav-item">
                    <a href="admin-dashboard.php">Admin Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item"><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<body>
    <style>
        .logo{
 
 display: flex;
 align-items: center;
 color: black;
 margin-left: -30px;
 font-size: 24px;
 color: white;
 height: 90px;
 padding-right: 550px;

}
.logo img{
 height: 55px;
 width: 66px;
 margin-left: 15px;

}

.logo h3{
 font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
 color: darkblue;
 
}

nav{
 display: flex;
 justify-content: space-around;
 align-items: center;
 height: 60px;
 
}


header ul{
 display: flex;

 
 list-style: none;
 margin: 0;
 padding: 0;
 font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;

 
}
header ul li{
 margin: 0 10px;
}
header ul a{
 text-decoration: none;
 color: black;

}
header ul li:hover{
 color: yellow;
 cursor: pointer;
 text-decoration: underline;
}
#home-item {
 color: yellow;
}
#home-item:hover{
 cursor: context-menu;
 text-decoration: none;
}
header{
 
 padding: 10px 20px;
 position: fixed; 
 top: 0; 
 left: 0; 
 width: 100%; 
 z-index: 1000;
}




        /* footer part*------------------------------------------------------------------------------------------------*/
        
footer{
    background-color: rgb(218, 197, 83);
    color: maroon;
    display: flex;
    align-items: center;
    flex-direction: column;
    padding: 10px;
    text-align: center;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
  
  
   
}
footer p{
    padding-top: 10px;
}

footer a{
    color: black;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    text-decoration: none;
    
}
footer a:hover
{
    text-decoration: underline;
    color:red ;
    
}
.space{
    height: 450px;
}

    </style>
</body>


<div class="space">

</div>

<footer>
        <p>&copy; 2024 All rights reserved by <b>Event Vibes</b>, Designed by <a href="https://bijon2002.github.io/portfolio/">Bijon Solutions...</a></p>
    </footer>

