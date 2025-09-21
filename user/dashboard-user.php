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
         align-items: center;
      }
      .navbar .right{
         margin-left: 0;
      }

      .navbar .left{
         margin-right: 0;
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

      .insert{
           padding: 8px 16px;
  background-color: black;
  color: white;
  border: none;
  border-radius: 6px;
  text-decoration: none;
  cursor: pointer;
      left: 0;
      position: absolute;
      }
      
     .logout{
             
  padding: 8px 16px;
  background-color: black;
  color: white;
  border: none;
  border-radius: 6px;
  text-decoration: none;
  cursor: pointer;
      right: 0;
      position: absolute;
            
     }
   </style>
</head>
<body>
       
<nav class="navbar">
   <div class="Shoplogo"></div>
   <a href='../product/insert-product.php' class='insert'>Insert product</a>
   <?php
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login-user.php");
    exit;
}

echo "<a href='logout-user.php' class='logout'>Logout</a>";

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
