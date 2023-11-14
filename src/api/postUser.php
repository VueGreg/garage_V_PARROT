<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
    postUser();
}else return_json(false, "La methode POST est requise");


function postUser()
{
    try{
        $_POST = json_decode(file_get_contents('php://input'), true);

        global $data;

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $token = bin2hex(openssl_random_pseudo_bytes(64));

        $sql= "INSERT INTO utilisateurs (`id`, `nom`, `prenom`,`mdp`,`mail`,`token`,`id_permissions`) 
                VALUES (NULL, :name, :surname, :password, :email, :token, :role)";

        $statement = $data->prepare($sql);

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':token', $token, PDO::PARAM_STR);
        $statement->bindParam(':role', $role, PDO::PARAM_INT);

        $statement->execute();

        $result = array(
            "nom" => $name,
            "prenom" => $surname
        );

        return_json(true, "Le nouvel utilisateur à été créé", $result);

    } catch (Exception $e){ return_json(false, $e->getMessage());}
}