<?php
session_start();
require "../includes/user-class.php";
try{
 if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $user = new User();

       // XSS prevention
    $email = htmlspecialchars($_POST['email']); 
    $wachtwoord = htmlspecialchars($_POST['wachtwoord']);

   $dbuser = $user->userLogin($email);

   if ($dbuser){
      if (password_verify($wachtwoord, $dbuser["password"])) {
         $_SESSION['user'] = [
         "id" => $dbuser["id"],
         "email" => $dbuser["email"]
      ];
      echo "inloggen gelukt!";
    header("Location: dashboard-user.php");
    exit;
      }else{
        echo "wachtword oonjuist";

   }
   }
}
 
}catch(Exception $e){
 $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login test</title>
</head>
<body>
   <form method="POST">
   <input type="email" name="email" placeholder="email" required>
   <input type="password" name="wachtwoord" placeholder="wachtwoord" required>
   <input type="submit" value="Login">
   </form>
</body>
</html>