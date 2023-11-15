<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
    postMessage();
}
elseif ($request_method == 'PUT') {
    validateMessage();
}
else return_json(false, "La methode POST est requise");


function postMessage()
{
    try{

        $_POST = json_decode(file_get_contents('php://input'), true);

            global $data;

            $date = $_POST['date'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $message = $_POST['message'];
            $tel = $_POST['tel'];
            $mail = $_POST['mail'];
            $numAnnonce = $_POST['numAnnonce'];
            $status = 0;

            if ($_POST['numAnnonce'] == 0) {
                $numAnnonce = NULL;
            }

            $sql= "INSERT INTO messages (`id`, `nom`, `prenom`, `num_telephone`, `mail`, `date`, `text`, `status`, `num_annonce`) 
                VALUES (NULL, :name, :surname, :tel, :mail, :date, :message, :status, :numAnnonce)";

            $statement = $data->prepare($sql);

            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
            $statement->bindParam(':tel', $tel, PDO::PARAM_STR);
            $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
            $statement->bindParam(':date', $date, PDO::PARAM_STR);
            $statement->bindParam(':message', $message, PDO::PARAM_STR);
            $statement->bindParam(':status', $status, PDO::PARAM_INT);
            $statement->bindParam(':numAnnonce', $numAnnonce, PDO::PARAM_INT);


            $statement->execute();

            $result = array(
                "date" => $date,
                "nom" => $name,
                "prenom" => $surname,
                "message" => $message,
                "tel" => $tel,
                "email" => $mail,
                "annonce" => $numAnnonce
            );

            return_json(true, "Insertion reussi", $result);

    } catch (Exception $e){ return_json(false, $e->getMessage());}
}

function validateMessage () {

    try {
        $_PUT = json_decode(file_get_contents('php://input'), true);

        if (isset($_PUT['validate']) && isset($_PUT['id'])) {
            
            global $data;

            $statement = $data->prepare("UPDATE messages SET status = '1' WHERE `messages`.`id` = :id");
            $statement->bindParam(':id', $_PUT['id']);
            
            if ($statement->execute()) {
                return_json(true, 'Message traité');
            }

        } else return_json(false, 'Une erreur s\'est produite');
        
    }catch (Exception $e){ return_json(false, $e->getMessage());}
}