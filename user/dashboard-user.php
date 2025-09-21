<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <style>
      body{
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
         background: linear-gradient(to right, #00ffeeff, #0400ffff 100%);
      }
       .navbar{
         background-color: gray;
         overflow: hidden;
         height: 65px;
         display: flex;
         left: 0;
      }
      .bottom{
         position: fixed;
         bottom: 0;
         width: 100%;
         justify-content: center;
         align-items: center;
         text-align: center;
         background-color: gray;
      }

      
     .logout{
             position: fixed;
             right: 0;
             color: white;
             text-decoration: none;
             gap: 2rem;
             padding: 0px;
             border-radius: 5px;
             background-color: black;
             max-height: 20px;
             text-align: center;
             
            margin: 0;
            top: 0;
            
     }
   </style>
</head>
<body>
       
<nav class="navbar">
   <div class="Shoplogo"></div>
   <?php
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login-user.php");
    exit;
}

echo "<strong><br><a class='logout' href='logout-user.php'>Logout</a></strong> ";


?>
</nav>

<?php

if (empty($_SESSION['user'])) {
    header("Location: login-user.php");
    exit;
}

echo "Welkom " . $_SESSION['user']['email'] . " op je dashboard!";


?>
<footer class="bottom">
   <p> &copy; 2025 Shop</p>
</footer>
</body>
</html>
