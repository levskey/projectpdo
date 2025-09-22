<?php
include "../includes/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
    "width=device-width, initial-scale=1.0">    
</head>

<body>
    <?php

    $db = new DB();

    $pdo = $db->getPDO();
    
    $stmt = $pdo->prepare('select * from images');
    $stmt->execute();
    $imagelist = $stmt->fetchAll();
 
    foreach($imagelist as $image) {
    ?>
       
    <img src="<?=$image['image']?>" 
        title="<?=$image['name'] ?>" 
        width='200' height='200'>
        <p><?=$image['description']?></p>
        <p><?=$image['price']?></p>
    <?php
    }
    ?> 
</body>

</html>