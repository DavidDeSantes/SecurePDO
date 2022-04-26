<?php

class Controller
{

    private $connection;
    private $user;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getUser($form_username)
    {
        // PDO gère l'injection SQL en 3 étapes :
        try {
            // Faire de la requête SQL
            $sql = "SELECT username, password FROM user WHERE username = LOWER(:uname) ; ";

            //Requête préparée dans le serveu, envoi au serveur mais pas encore l'execution (1er : Préparation)
            $statement = $this->connection->prepare($sql);

            //injection des paramètres (2eme : Compilation)
            $statement->bindParam("uname", $form_username);

            //Execution de la requête (3eme : Execution)

            $statement->execute();

            // On récupère l'objet utilisateur de la base de données 
            $this->user = $statement->fetch();

            return $this->user;
           }
        catch (Exception $error){
            return $error->getMessage();
        }
    }
       // vérifier si le password correspond au user
         public function verify_password($upwd){
             return password_verify($upwd, $this->user['password']);
        }

    
    public function addUser($uname, $pass){
        try{
            $sql = "INSERT INTO user (username, password) VALUES (:name, :pwd)";

            $statement = $this->connection->prepare($sql);

            $statement->bindParam("name", $uname);
            $statement->bindParam("pwd", $pass);

           return $statement->execute();

        }catch(Exception $error){
            return $error->getMessage();
        }
    }
}
