<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
    postConnection();
}else return_json(false, "La methode POST est requise");


function postConnection()
{
    try{
        $_POST = json_decode(file_get_contents('php://input'), true);

        global $data;

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT *, permissions.rang AS permissions_lvl, permissions.type AS permissions_name
                FROM utilisateurs 
                INNER JOIN permissions ON permissions.id = id_permissions
                WHERE mail LIKE :email AND mdp LIKE :password";

        $statement = $data->prepare($sql);
        $statement-> bindParam(':email', $email);
        $statement-> bindParam(':password', $password);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $id = $user['id'];

        //Création du token pour la permissions
        $token = bin2hex(openssl_random_pseudo_bytes(64));

        $sql_token = "UPDATE `utilisateurs` SET `token` = :token WHERE `utilisateurs`.`id` = :id";

        $statement = $data->prepare($sql_token);
        $statement-> bindParam(':token', $token);
        $statement-> bindParam(':id', $id);
        $statement->execute();

        $result['permissions'] = $token;
        $result['name'] = $user['nom'];
        $result['surname'] = $user['prenom'];


        return_json(true, "Connexion reussi", $result);

    } catch (Exception $e){ return_json(false, $e->getMessage());}
}