<?php
require "db.php";

class User {
private $pdo;

public function __construct(){
    $this->pdo = new DB(); 
}
public function registerUser(string $email, string $wachtwoord){
    $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
    $this->pdo->run("INSERT INTO user ( email, password) VALUES ( :email, :wachtwoord)",
    ["email"=>$email, "wachtwoord"=>$hash]);
}

public function userLogin(string $email) {
    return $this->pdo->run("SELECT * FROM user WHERE email = :email",["email" => $email])->fetch();
}
}
