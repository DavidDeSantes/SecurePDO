<?php
require_once('MyError.php');
session_start();
// On crée en session un token qui sera de base une chaine binaire avec la fonction random_bytes en paramètre le nombre de caractères
// binaire qu'on souhaite et de plus, on transforme notre chaine binaire en Hexadecimal avec la fonction bin2hex
$_SESSION['token'] = bin2hex(random_bytes(24));
   
   if(!isset($_SESSION['error'])){
      $_SESSION['error'] = new MyError;
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure V2</title>
</head>
<body>
    <p style="color: red">
       <?php 
           if(isset($_GET['error'])){
               echo "<strong>".$_SESSION['error']."</strong>"; 
           }
       ?>
    </p>
    <?php 

    if(!isset($_SESSION['user'])){
        echo "<h2> Connectez-vous  Ou <a href='sign_in.php'>Inscrivez-vous !</a></h2>";
    }
    else{
        echo "<h2> Bienvenue ".ucwords($_SESSION['user']['username'])."</h2>";
        echo "<h2><a href='logout.php'>Deconnexion<a></h2>";
    }

    ?>
    <!-- form: method post pour ne pas avoir les données dans l'url avec la method get -->
    <form action="login.php" method="post">
        <!-- input: le placehorder est pour avoir notre chaine de carctère dans le champ d'écriture -->
        <p><input type="text" placeholder="Votre login" name="username" required></p>

        <p><input type="password" placeholder="votre mot de passe" name="password" require></p>
        <!-- On a fait un champ invisible pour y placer le token -->
        <p><input type="hidden" value="<?= $_SESSION['token']?>" name="token"></p>

        <p><input type="submit" value="Connexion" require></p>
    </form>
</body>
</html>