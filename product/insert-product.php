<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
       <style>
      body{
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
         background: linear-gradient(to right, #00ffeeff, #0400ffff 100%);
      }
      .navbar{
         background-color: gray;
         overflow: hidden;
         height: 65px;
         display: flex;
         align-items: center;
         left: 0;
      }
        .navbar a {
            margin-left: 20px;
            color: white;
            text-decoration: none;
        }
      .logincontainer{
         padding: 0;
         margin-bottom: 100px;
         min-width: 650px;
         max-width: 650px;
         max-height: 500px;
         background-color: gray;
         min-height: 400px;
         border: 1px solid #4a4444ff;
         box-shadow: 0 2px 8px rgba(0.3,0.3,0.3,0.3);
         border-radius: 20px;
         text-align: left;
         
      }

      #Dsign{
        left: 0;
        top: 0;
        border-radius: 8px;
        border: none;
        vertical-align: top;
        margin: 8px;
      }
      .Beschrijving{
         width: 300px;
        height: 120px;
      }
      .Productname{
         margin-left: 10px;
         border: none;
         margin-top: 10px;
         border-radius: 8px;
      }

  .button{

         display: flex;
         justify-self: center;
         gap: 1rem;
         display: inline-block;
         margin: 5px;
         min-width: 100px;
         min-height: 35px;
         border-radius: 6px;
         box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
         background-color: #008cffff;
         border: none;
         cursor: pointer;
      }
      .button:hover{
         scale: 1.05;
         transition: 0.3s;
      }

      .wrapper {
    display: flex;
    vertical-align: middle;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.file{
    margin: 5px;
}

      .button:hover{
              color: white;
         background-color: #003e70ff;
      }
      .emailpass{
         display: flex;
         justify-self: center;
         gap: 1rem;
         margin: 0;
         margin-top: 0;
      }
      .bottom{
         bottom: 0;
         justify-self: center;
         width: 100%;
         justify-content: center;
         align-items: center;
         text-align: center;
         background-color: gray;
      }

      .toevoegen{
         margin-left: 15px;
            padding: 0;
            color: white;
            text-shadow: #000000ff 1px 0 10px;

      }

         .Maintext{
            font-size: 30px;
            padding: 0;
            margin: 0;
            gap: 2rem;
            color: white;
            text-shadow: #00fff2ff 1px 0 10px;

            padding: 20px;
         }
   </style>
</head>
<body>
    <nav class="navbar">
  <strong><h3 class="Maintext">Webshop</h3></strong>
  <a href="./view-product.php">bekijk producten</a> 
  <br>
    <a href="./../user/dashboard-user.php">Dashboard</a>
</nav>
<?php
include "../includes/db.php";
  
if(isset($_POST['submit'])) {
   $db = new DB();  
   $pdo = $db->getPDO();
 
    // Count total files
    $countfiles = count($_FILES['files']['name']);
  
    // Prepared statement
    $query = "INSERT INTO producten (productname,name,image,description,price) VALUES(?,?,?,?,?)";
 
    $statement = $pdo->prepare($query);
 
    // Loop all files
    for($i = 0; $i < $countfiles; $i++) {
 
        // File name
        $filename = $_FILES['files']['name'][$i];
     
        // Location
        $target_file = './uploads/'.$filename;
     
        // file extension
        $file_extension = pathinfo(
            $target_file, PATHINFO_EXTENSION);
            
        $file_extension = strtolower($file_extension);
     
        // Valid image extension
        $valid_extension = array("png","jpeg","jpg");
     
        if(in_array($file_extension, $valid_extension)) {
 
            // Upload file
            if(move_uploaded_file(
                $_FILES['files']['tmp_name'][$i],
                $target_file)
            ) {

                // Execute query
                $statement->execute([
    $_POST['Productname'],   // productname (normal name you typed)
    $filename,               // name (original file name, e.g. shoe.jpeg)
    $target_file,            // image (file path in uploads/)
    $_POST['Beschrijving'],  // description (your text)
    $_POST['prijs']          // price (the number)
]);

            }
        }
    }
    
    echo "File upload successfully";
}
?>

<div class="wrapper">
<div class="logincontainer">
   <strong><h2 class="toevoegen">Product toevoegen</h2></strong>
   <form method="POST" enctype="multipart/form-data">
        <input type="text" name="Productname" id="Productname" class="Productname" placeholder="Productnaam" required  >
        <br>
        <textarea class="Beschrijving" name="Beschrijving" id="Dsign" placeholder="Beschrijving..." required></textarea>
        <br>
        <input type="number" step="0.01" name="prijs" id="Dsign" placeholder="12.99 ofzo" required>
         <br>
         <input type="file" class="file" name="files[]" id="files" required multiple />
         <br>
         <input type="submit" name="submit" class="button" value="Toevoegen">
   </form>
</div>
</div>
<footer class="bottom">
   <p> &copy; 2025 Shop</p>
</footer>
</body>
</html>
