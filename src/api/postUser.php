<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
    postUser();
}
elseif ($request_method == 'PUT') {
    modifyUser();
}else return_json(false, "La methode POST est requise");


function postUser()
{
    try{
        $_POST = json_decode(file_get_contents('php://input'), true);

        if (isset($_POST['id'])) {

            $id = $_POST['id'];

            global $data;
            
            $statement = $data->prepare("DELETE FROM utilisateurs WHERE id = $id");
            if ($statement->execute()) {
                return_json(true, 'Utilisateur supprimé');
            }

        }
        else {

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
        }

    } catch (Exception $e){ return_json(false, $e->getMessage());}
}


function modifyUser() {
    try {

        $_PUT = json_decode(file_get_contents('php://input'), true);

        if (isset($_PUT['id']) && isset($_PUT['name']) && isset($_PUT['surname']) && isset($_PUT['role']) && isset($_PUT['mail'])) {
            
            $id = $_PUT['id'];
            $name = $_PUT['name'];
            $surname = $_PUT['surname'];
            $mail = $_PUT['mail'];
            $role = $_PUT['role'];

            global $data;

            $sql = "UPDATE utilisateurs SET nom = :name, prenom = :surname, mail = :mail, id_permissions = :role
                    WHERE id = :id";

            $statement = $data->prepare($sql);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':surname', $surname);
            $statement->bindParam(':mail', $mail);
            $statement->bindParam(':role', $role);
            $statement->bindParam(':id', $id);

            if ($statement->execute()) {
                return_json(true, 'Utilisateur modifié');
            }
        }

    }catch (Exception $e){ return_json(false, $e->getMessage());}
}