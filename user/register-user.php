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
         align-items: center;
         left: 0;
      }
      .logincontainer{
         display: flex;
         padding: 0;
         margin: 0;
         justify-self: center;
         gap: 1rem;
         min-width: 300px;
         background-color: gray;
         min-height: 200px;
         margin-top: 200px;
         border: 1px solid #4a4444ff;
         align-content: center;
         box-shadow: 0 2px 8px rgba(0.3,0.3,0.3,0.3);
         border-radius: 20px;
         justify-content: center;
         align-items: center;
      }
  .button{
         display: flex;
         justify-self: center;
         gap: 1rem;
         display: inline-block;
         margin-top: 5px;
         min-width: 100px;
         min-height: 35px;
         border-radius: 6px;
         box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
         background-color: #008cffff;
         border: none;
         cursor: pointer;
      }
      .button:hover{
         scale: 1.05;
         transition: 0.3s;
      }

      .button:hover{
              color: white;
         background-color: #003e70ff;
      }
      .emailpass{
         display: flex;
         justify-self: center;
         gap: 1rem;
         margin: 0;
         margin-top: 0;
      }
      .bottom{
         position: fixed;
         bottom: 0;
         justify-self: center;
         width: 100%;
         justify-content: center;
         align-items: center;
         text-align: center;
         background-color: gray;
      }

         .Maintext{
            font-size: 30px;
            padding: 0;
            margin: 0;
            gap: 2rem;
            color: white;
            text-shadow: #00fff2ff 1px 0 10px;

            padding: 20px;
         }
   </style>
</head>
<body>
    <nav class="navbar">
  <strong><h3 class="Maintext">Webshop</h3></strong> 
</nav>
<?php
require "../includes/user-class.php";
try{
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $user = new User();

        // XSS prevention
        $email = htmlspecialchars($_POST['email']); 
        $wachtwoord = htmlspecialchars($_POST['wachtwoord']);

        $user->registerUser($email, $wachtwoord);
        header("Location: login-user.php");
        exit;
        

    }
}catch(Exception $e){
if ($e->getCode() == 23000 ){ 
    echo "  Dit emailadres is al in gebruik.";}
    else
      echo "er is een fout opgetreden: " . $e->getMessage();
}

?>
<div class="logincontainer">
   <form method="POST">
   <input class="emailpass" type="email" name="email" placeholder="email" required>
   <br>
   <input class="emailpass" type="password" name="wachtwoord" placeholder="wachtwoord" required>
   <br>
   <input class="button" type="submit" value="Register">
   <input class="button" type="button" value="Login" onclick="window.location.href='login-user.php'">
   </form>
</div>
<footer class="bottom">
   <p> &copy; 2025 Shop</p>
</footer>
</body>
</html>
