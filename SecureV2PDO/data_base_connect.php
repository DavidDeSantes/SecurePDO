<?php

//tenter de me connecter à la base de données 

try{
    $connection = new PDO(
        'mysql:host=localhost:3306;dbname=pdo_v2',
        'root',
        '');
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
catch(Exception $error){
    echo $error->getMessage();
}