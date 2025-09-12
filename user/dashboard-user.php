<?php
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login-user.php");
    exit;
}

echo "Welkom " . $_SESSION['user']['email'] . " op je dashboard!";
echo "<br><a href='logout-user.php'>Logout</a>";






















?>