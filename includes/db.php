<?php
class DB {
    protected $pdo;
    public function __construct($db = "winkel", $user="root", $pwd="", $host = "localhost"){
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function run($sqlquery,$args){
        $stmt = $this->pdo->prepare($sqlquery);
        $stmt->execute($args);
        return $stmt;
    }

        // 👇 Getter method to expose PDO directly
    public function getPDO() {
        return $this->pdo;
    }

   public function updateProduct($id, $name, $description, $price, $image) {
    $sql = "UPDATE producten 
            SET productname = ?, description = ?, price = ?, image = ?
            WHERE id = ?";
    return $this->run($sql, [$name, $description, $price, $image, $id]);
}

    
}








?>