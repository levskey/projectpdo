<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #00ffeeff, #0400ffff 100%);
        }
        .navbar {
            position: fixed;
            background-color: gray;
            overflow: hidden;
            height: 65px;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        .navbar a {
            margin-left: 20px;
            color: white;
            text-decoration: none;
        }
        .Maintext {
            font-size: 30px;
            margin: 0;
            color: white;
            text-shadow: #00fff2ff 1px 0 10px;
        }
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }
        .buttonedit {
    display: inline-block;
    margin: 5px 5px 0 0;
    padding: 8px 15px;
    border-radius: 6px;
    border: none;
    background-color: #008cffff;
    color: white;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
}

        .buttondelete {
    display: inline-block;
    margin: 5px 5px 0 0;
    padding: 8px 15px;
    border-radius: 6px;
    border: none;
    background-color: #ff0000ff;
    color: white;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
}
.buttonedit:hover {
    background-color: #003e70ff;
    transition: 0.3s;
}

.buttondelete:hover{
    background-color: #700000ff;
    transition: 0.3s;
}

        .logincontainer {
            background-color: gray;
            border-radius: 20px;
            padding: 20px;
            max-width: 800px;
            width: 100%;
            margin-top: 150px;
            box-shadow: 0 2px 8px rgba(0.3,0.3,0.3,0.3);
        }
        .product {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
        }
        .product img {
            border-radius: 10px;
            display: block;
            margin-bottom: 10px;
        }
        .bottom {
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: gray;
            color: white;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h3 class="Maintext">Webshop</h3>
        <a href="./insert-product.php">producten toevoegen</a>
        <br>
        <a href="./../user/dashboard-user.php">Dashboard</a>
    </nav>

    <div class="wrapper">
        <div class="logincontainer">
            <?php
            include "../includes/db.php";
            $db = new DB();
            $pdo = $db->getPDO();

            $stmt = $pdo->prepare('SELECT * FROM producten');
            $stmt->execute();
            $productlist = $stmt->fetchAll();

            foreach($productlist as $product) {
                ?>
              <div class="product">
 
    <img src="./uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['productname']) ?>"
         alt="<?= htmlspecialchars($product['productname']) ?>" 
         width="200" height="200">
    <h4><?= htmlspecialchars($product['productname']) ?></h4>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p><strong>€<?= htmlspecialchars($product['price']) ?></strong></p>

    <!-- Nieuwe knoppen -->
    <a href="./edit-product.php?id=<?= $product['id'] ?>" class="buttonedit">Aanpassen</a>
    <a href="./delete-product.php?id=<?= $product['id'] ?>" class="buttondelete">Verwijderen</a>

</div>

                <?php
            }
            ?>
        </div>
    </div>

    <footer class="bottom">
        <p>&copy; 2025 Shop</p>
    </footer>
</body>
</html>
