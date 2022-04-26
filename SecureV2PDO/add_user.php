<?php

require_once("data_base_connect.php");
require_once("MyError.php");
require_once("controller.php");

session_start();

$controller = new Controller($connection);

// les regex ne marche pas avec filter full special chars voir
// $form_username = htmlentities(trim($_POST['username']));
$form_username = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_REGEXP, [
    "options" => [
        "regexp" => '#^[A-Za-z][A-Za-z0-9_]{5,29}$#'
    ]
]);

if (is_string($form_username)) {
    //Les regex 
    // $form_password = htmlentities(trim($_POST['password']));
    $form_password = filter_input(INPUT_POST, 'password',FILTER_VALIDATE_REGEXP, [
        "options" => [
            "regexp" => '#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$#'
        ]
    ]);

    if (is_string($form_password)) {

        $user = $controller->getUser($form_username);

        if (is_array($user)) {
            $_SESSION['error']->setError(102, "cet identifiant est déjà pris! Veuillez en choisir un autre...");
            header("Location:sign_in.php?error");
        } else { // Password_hash est une fonction qui nous transformer notre mdp en chaine de caractère complexe grâce a un aglo choisis (ARGON2I ou BCRYPT)
            $password2 = filter_input(INPUT_POST, "pwdverif", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            //on crée la variable token qui est donc le input type hidden 
            $token = filter_input(INPUT_POST, 'token',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($password2 === $form_password) {
                $status = $controller->addUser(strtolower($form_username), password_hash($form_password, PASSWORD_ARGON2I));
                // est on va comparer le token de la session associer pour éviter les failles CSRF
                if (($status) && (hash_equals($_SESSION['token'], $token))){
                    header("Location:index.php");
                }else{
                    $_SESSION['error']->setError(103, "Erreur Inconnue ! Veuillez réessayer...");
                    header("Location:sign_in.php?error");
                }
            }else {
                $_SESSION['error']->setError(104, "Les 2 mots de passe ne sont pas identiques");
                header("Location:sign_in.php?error");
            }
        }

    }else{
        $_SESSION['error']->setError(105, "Le mot de passe doit avoir 8 caractères au moins.");
                header("Location:sign_in.php?error");
    }
}else{
    $_SESSION['error']->setError(106, "Le username doit avoir 5 caractères au moins");
                header("Location:sign_in.php?error");
}
