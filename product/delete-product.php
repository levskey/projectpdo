<?php
session_start();
include "../includes/db.php";
$db = new DB();
$pdo = $db->getPDO();

// Controleer of er een ID is meegegeven
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Geen product ID opgegeven.";
    header("Location: view-product.php");
    exit();
}

$id = $_GET['id'];
$message = "";

// Haal productgegevens op
$stmt = $pdo->prepare("SELECT * FROM producten WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $_SESSION['error'] = "Product niet gevonden.";
    header("Location: view-product.php");
    exit();
}

// Verwerk het verwijderen na bevestiging
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['bevestig_verwijderen'])) {
    $stmt = $pdo->prepare("DELETE FROM producten WHERE id = ?");
    
    if ($stmt->execute([$id])) {
        // Verwijder eventueel de bijbehorende afbeelding
        if (!empty($product['image']) && file_exists("uploads/" . $product['image'])) {
            @unlink("uploads/" . $product['image']);
        }
        
        $_SESSION['success'] = "Product succesvol verwijderd.";
        header("Location: view-product.php");
        exit();
    } else {
        $message = "Er is een fout opgetreden bij het verwijderen van het product.";
    }
}
?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product verwijderen</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #00ffeeff, #0400ffff 100%);
        }

        .navbar {
            position: fixed;
            background-color: gray;
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

        .logincontainer {
            background-color: gray;
            border-radius: 20px;
            padding: 25px;
            max-width: 500px;
            width: 100%;
            margin-top: 50px;
            box-shadow: 0 2px 8px rgba(0.3, 0.3, 0.3, 0.3);
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: white;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: none;
        }

        button {
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
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        button:hover {
            background-color: #cc0000;
            transition: 0.3s;
        }
        
        .button {
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
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .button:hover {
            background-color: #003e70ff;
            transition: 0.3s;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            color: white;
        }

        .product-preview {
            background: white;
            border-radius: 10px;
            padding-right: 15px;
            margin-bottom: 15px;
            text-align: center;
        }

        .product-preview img {
            max-width: 200px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .bottom {
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: gray;
            color: white;
            padding: 10px 0;
            position: relative;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h3 class="Maintext">Webshop</h3>
        <a href="./insert-product.php">producten toevoegen</a>
        <a href="./../user/dashboard-user.php">Dashboard</a>
    </nav>

    <div class="wrapper">
        <div class="logincontainer">
            <h2>Product verwijderen</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <p class="message" style="color: #ff6b6b;"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <?php if ($message): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <div class="product-preview">
                <h3>Weet u zeker dat u dit product wilt verwijderen?</h3>
                <h4><?= htmlspecialchars($product['productname']) ?></h4>
                <?php if (!empty($product['image'])): ?>
                    <img src="./uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['productname']) ?>" style="max-width: 200px;">
                <?php endif; ?>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p><strong>€<?= htmlspecialchars($product['price']) ?></strong></p>
                
                <form method="POST" onsubmit="return confirm('Weet u zeker dat u dit product wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.');">
                    <button type="submit" name="bevestig_verwijderen" style="background-color: #ff4444; margin-right: 10px;">Ja, verwijderen</button>
                    <a href="view-product.php" class="button" style="display: inline-block; background-color: #666; padding: 8px 15px; border-radius: 6px; color: white; text-decoration: none;">Annuleren</a>
                </form>
            </div>
        </div>
    </div>

    <footer class="bottom">
        <p>&copy; 2025 Shop</p>
    </footer>

</body>
<script>

</script>
</html>