<?php
require_once("MyError.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in</title>
</head>
<body>
    <p style="color: red">
       <?php 
           if(isset($_GET['error'])){
               echo "<strong>".$_SESSION['error']."</strong>"; 
           }
       ?>
    </p>
    <h1>
        Inscription 
    </h1>
    <form action="add_user.php" method="post">

        <p><input type="text" placeholder="Votre login" name="username" require></p>

        <p><input type="password" placeholder="Votre mot de passe" name="password" require></p>

        <p><input type="hidden" value="<?= $_SESSION['token']?>" name="token"></p>

        <p><input type="password" placeholder="Répétez le mot de passe" name="pwdverif" require></p>
      
        <input type="submit" value="inscription">

    </form>
</body>
</html>