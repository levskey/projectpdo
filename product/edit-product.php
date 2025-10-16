<?php
include "../includes/db.php";
$db = new DB();
$pdo = $db->getPDO();

if (!isset($_GET['id'])) {
    die("Geen product ID opgegeven.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM producten WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product niet gevonden.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['productname'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // upload map zonder spatie, map moet bestaan
    $uploadDir = './uploads/';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $originalName = $_FILES['image']['name'];
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $safeName = preg_replace("/[^A-Za-z0-9_\-]/", "_", pathinfo($originalName, PATHINFO_FILENAME));
        $filename = $safeName . '_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // het pad voor in de database
            $imagePath = $filename;
        } else {
            $imagePath = $product['image'];
            $message = "Fout bij uploaden, oude afbeelding behouden.";
        }
    } else {
        $imagePath = $product['image'];
    }

    if ($db->updateProduct($id, $name, $description, $price, $imagePath)) {
        $message = "Product succesvol bijgewerkt!";
        $product['productname'] = $name;
        $product['description'] = $description;
        $product['price'] = $price;
        $product['image'] = $imagePath;
    } else {
        $message = "Er ging iets mis bij het bijwerken.";
    }
}
?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product aanpassen</title>
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
            background-color: #008cffff;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 14px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        button:hover {
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
            <h2>Product aanpassen</h2>

            <?php if ($message): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <div class="product-preview">
                <h4><?= htmlspecialchars($product['productname']) ?></h4>
                <img src="./uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['productname']) ?>">
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p><strong>€<?= htmlspecialchars($product['price']) ?></strong></p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <label>Productnaam:</label>
                <input type="text" name="productname" value="<?= htmlspecialchars($product['productname']) ?>" required>

                <label>Beschrijving:</label>
                <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

                <label>Prijs (€):</label>
                <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

                <label>Afbeelding uploaden:</label>
                <input type="file" name="image">

                <button type="submit">Opslaan</button>
            </form>
        </div>
    </div>

    <footer class="bottom">
        <p>&copy; 2025 Shop</p>
    </footer>

</body>

</html>