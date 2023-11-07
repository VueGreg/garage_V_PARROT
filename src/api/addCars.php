<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
        getCars();
}else return_json(false, "La methode POST est requise");

function getCars() {
    $_POST = json_decode(file_get_contents("php://input"),true);

    try {
        if(empty($_POST)) {
            $sql_modeles = "SELECT DISTINCT modele FROM vehicules";
            
            global $data;

            $statement = $data->prepare($sql_modeles);
            $statement->execute();
            $modeles = $statement->fetchAll(PDO::FETCH_COLUMN);
    
            
        }
        elseif (isset($_POST['mark'])) {
            $sql_modeles = "SELECT DISTINCT modele FROM vehicules WHERE marque LIKE :mark";

            global $data;
            $statement = $data->prepare($sql_modeles);
            $statement ->bindParam(':mark', $_POST['mark']);
            $statement->execute();
            $modeles = $statement->fetchAll(PDO::FETCH_COLUMN);
        }

            $sql_marques = "SELECT DISTINCT marque FROM vehicules";
            $sql_energies = "SELECT * FROM energies";
            $sql_equipements = "SELECT DISTINCT * FROM equipements";

            global $data;

            $statement = $data->prepare($sql_marques);
            $statement->execute();
            $marques = $statement->fetchAll(PDO::FETCH_COLUMN);

            $statement = $data->prepare($sql_energies);
            $statement->execute();
            $energies = $statement->fetchAll(PDO::FETCH_ASSOC);

            $statement = $data->prepare($sql_equipements);
            $statement->execute();
            $equipements = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            $result["marques"] = $marques;
            $result["modeles"] = $modeles;
            $result["energies"] = $energies;
            $result["equipements"] = $equipements;
            
            return_json(true, 'Informations obtenus', $result);

    } catch (PDOException $e) {
        return_json(false, getMessages($e));
    }
    
}