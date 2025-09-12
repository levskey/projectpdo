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
echo "er is een fout opgetreden: " . $e->getMessage();
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
   <form  method="POST">
   <input type="email" name="email" placeholder="email" required>
   <input type="password" name="wachtwoord" placeholder="wachtwoord" required>
   <input type="submit" value="Register">
   </form>
</body>
</html>