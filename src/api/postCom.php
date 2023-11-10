<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
    postCommentaires();
}elseif ($request_method == 'PUT') {
        commentaryAccept();
}else return_json(false, "La methode POST est requise");


function postCommentaires()
{
    try{
        $_POST = json_decode(file_get_contents('php://input'), true);

        global $data;

        $date = $_POST['date'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $com = $_POST['com'];
        $note = $_POST['note'];

        $sql= "INSERT INTO temoignages (`id`, `date`, `nom`, `prenom`, `commentaire`, `note`, `id_image`) 
            VALUES (NULL, :date_post, :nom, :prenom, :commentaire, :note, NULL)";

        $statement = $data->prepare($sql);

        $statement->bindParam(':date_post', $date, PDO::PARAM_STR);
        $statement->bindParam(':nom', $name, PDO::PARAM_STR);
        $statement->bindParam(':prenom', $surname, PDO::PARAM_STR);
        $statement->bindParam(':commentaire', $com, PDO::PARAM_STR);
        $statement->bindParam(':note', $note, PDO::PARAM_INT);

        $statement->execute();

        $result = array(
            "date" => $date,
            "nom" => $name,
            "prenom" => $surname,
            "commentaire" => $com,
            "note" => $note
        );

        return_json(true, "Insertion reussi", $result);

    } catch (Exception $e){ return_json(false, $e->getMessage());}
}

function commentaryAccept() {

    $_PUT = json_decode(file_get_contents('php://input'), true);

    if (isset($_PUT['accept']) && isset($_PUT['id'])) {

        $id = $_PUT['id'];
        $state = $_PUT['accept'];

        if ($state == 'yes') {

            try {
                $sql = "UPDATE temoignages SET etat = '1' WHERE id = :id";
    
                global $data;
                $statement = $data->prepare($sql);
                $statement->bindParam(':id', $id);
                $statement->execute();
                return_json(true, 'temoignage accepté');
                
            } catch (Exception $e){ return_json(false, $e->getMessage());}
        }
        elseif ($state == 'no') {

            try {
                $sql = "DELETE FROM temoignages WHERE id = :id";
    
                global $data;
                $statement = $data->prepare($sql);
                $statement->bindParam(':id', $id);
                $statement->execute();
                return_json(true, 'temoignage effacé');
                
            } catch (Exception $e){ return_json(false, $e->getMessage());}
        }
    }else return_json(false, 'des paramètres sont manquant');
}
