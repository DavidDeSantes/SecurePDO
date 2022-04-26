<?php
//_once veut dire qu'il va récuper le fichier seulement quand t'il en a besoin, puis le laisser libre ensuite
require_once("data_base_connect.php");
require_once("MyError.php");
require_once("controller.php");

session_start();


//récuper le contenu de nos variables

$controller = new Controller($connection);

// Je récupère les champs du formulaire
    $form_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
   

    $user = $controller->getUser($form_username);

    if (is_array($user)){

        $form_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);

        $token = filter_input(INPUT_POST, 'token',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Grâce à un algorythme cette fonction va réussir à analyser l'emprunte numérique du password hash de notre mdp
        // est donc réussir à nous identifier si l'analyse est juste. 
        if($controller->verify_password($form_password)){
              // hash_equals est une fonction qui peux comparer 2 chaines de caractères hashé 
              if(hash_equals($_SESSION['token'], $token)){

              $_SESSION['user'] = $user;
              header("Location:index.php");
              }else{
                $_SESSION['error']->setError(107, "identification incorrect token ! Veuillez réessayer...");
                header("Location:index.php?error");
              }
        }
    }else{

        $_SESSION['error']->setError(101, "identification incorrect ! Veuillez réessayer...");
        header("Location:index.php?error");
    }

 