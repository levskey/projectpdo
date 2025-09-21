<?php
include "../includes/db.php"; 
$db = new DB(); // create DB instance

$stmt = $db->run("SELECT * FROM products", []); // run query
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
</head>
<body>
<?php foreach ($products as $product): ?>
    <div>
        <img src="<?= $product['image'] ?>" 
             title="<?= $product['Beschrijving'] ?>" 
             width="200" height="200"><br>
        Price: <?= $product['prijs'] ?><br>
        Description: <?= $product['Beschrijving'] ?><br>
    </div>
<?php endforeach; ?>
</body>
</html>
