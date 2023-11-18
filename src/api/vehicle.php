<?php

use function PHPSTORM_META\type;

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
        getCars();
}elseif ($request_method == 'PUT') {
        modifyCars();
}else return_json(false, "La methode POST est requise");


function getCars() {

        $_GET = json_decode(file_get_contents("php://input"),true);

        if (empty($_GET)) {

                global $data;

                $sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, status,
                energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele
                FROM annonces
                INNER JOIN energies ON annonces.id_energies = energies.id
                INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
                INNER JOIN galeries ON galeries.id_annonces = numero_annonce
                WHERE status = '0'
                GROUP BY numero_annonce";

                $annonces = simple_fetch_data($sql_annonces);

                foreach ($annonces as $key => $value) {

                        //Pictures
                        $id = $annonces[$key]['numero_annonce'];

                        $sql_photos =  "SELECT images.adresse AS photo 
                                        FROM galeries
                                        INNER JOIN images ON galeries.id_images = images.id
                                        WHERE id_annonces LIKE :id
                                        LIMIT 1";

                        $stmt = $data->prepare($sql_photos);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();

                        $annonces[$key]['photo'] = $stmt->fetch(PDO::FETCH_COLUMN);

                        //Messages
                        $sql_messages =  "SELECT * FROM messages WHERE num_annonce LIKE :id";

                        $stmt = $data->prepare($sql_messages);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();

                        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($messages != null) {
                                $annonces[$key]['messages'] = count($messages);
                        }else $annonces[$key]['messages'] = 0;

                }

        }elseif (isset($_GET['annonce']) || (isset($_GET['minyear']) && isset($_GET['maxyear']) && isset($_GET['minkilometer']) && isset($_GET['maxkilometer'])
                        && isset($_GET['mark']) && isset($_GET['model']) && isset($_GET['energy']) && isset($_GET['minprice']) && isset($_GET['maxprice']))){

                try {
                        
                        $annonce = $_GET['annonce'];
                        $minYear = $_GET['minyear'];
                        $maxYear = $_GET['maxyear'];
                        $minKilometer = $_GET['minkilometer'];
                        $maxKilometer = $_GET['maxkilometer'];
                        $mark = $_GET['mark'];
                        $model = $_GET['model'];
                        $energy = $_GET['energy'];
                        $minPrice = $_GET['minprice'];
                        $maxPrice = $_GET['maxprice'];
                
                        $sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, status,
                        energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele
                        FROM annonces
                        INNER JOIN energies ON annonces.id_energies = energies.id
                        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
                        WHERE numero_annonce LIKE :annonce AND status = 0
                        OR (
                                annee BETWEEN :minyear AND :maxyear
                                AND kilometrage BETWEEN :minkilometer AND :maxkilometer
                                AND marque LIKE :mark
                                AND modele LIKE :model
                                AND energies.nom LIKE :energy
                                AND prix BETWEEN :minprice AND :maxprice
                                AND status = 0
                        )";

                        //Remplacer les valeurs vide par une valeur traitable par BETWEEN
                        if ($annonce == "") {

                                if ($minYear == "") {
                                        $minYear = 1900;
                                }


                                if ($maxYear == "") {
                                        $currentDate = new DateTime();
                                        $maxYear = $currentDate->format("Y");
                                }

                                if ($minKilometer == "") {
                                        $minKilometer = 0;
                                }

                                if ($maxKilometer == "") {
                                        $maxKilometer = 500000;
                                }

                                if ($mark == "") {
                                        $mark = "%";
                                }

                                if ($model == "") {
                                        $model = "%";
                                }

                                if ($energy == "") {
                                        $energy = "%";
                                }

                                if ($minPrice == "") {
                                        $minPrice = 0;
                                }

                                if ($maxPrice == "") {
                                        $maxPrice = 500000;
                                }
                        }

                        global $data;
                        $statement = $data->prepare($sql_annonces);
                        $statement-> bindParam(":annonce", $annonce);
                        $statement-> bindParam(":minyear", $minYear);
                        $statement-> bindParam(":maxyear", $maxYear);
                        $statement-> bindParam(":minkilometer", $minKilometer);
                        $statement-> bindParam(":maxkilometer", $maxKilometer);
                        $statement-> bindParam(":mark", $mark);
                        $statement-> bindParam(":model", $model);
                        $statement-> bindParam(":energy", $energy);
                        $statement-> bindParam(":minprice", $minPrice);
                        $statement-> bindParam(":maxprice", $maxPrice);
                        $statement->execute();

                        $annonces = $statement->fetchAll(PDO::FETCH_ASSOC);

                        // Parcour du tableau pour définir les équipements et images
                        foreach ($annonces as $key => $value) {

                                $id = $annonces[$key]['numero_annonce'];

                                $sql_equipements ="SELECT equipements.id, equipements.categorie AS categorie , equipements.description AS equipement
                                        FROM list_equipements
                                        INNER JOIN equipements ON list_equipements.id_equipements = equipements.id
                                        WHERE id_annonces LIKE :id";
                                $stmt = $data->prepare($sql_equipements);
                                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                                $stmt->execute();

                                $annonces[$key]['equipements'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                $sql_photos =  "SELECT images.adresse AS photo 
                                        FROM galeries
                                        INNER JOIN images ON galeries.id_images = images.id
                                        WHERE id_annonces LIKE :id";

                                $stmt = $data->prepare($sql_photos);
                                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                                $stmt->execute();

                                $annonces[$key]["images"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $stmt->execute();
                                $annonces[$key]["photo"] = $stmt->fetch(PDO::FETCH_COLUMN);
                        }
                

                } catch (Exception $e){ return_json(false, $e->getMessage());}
        }

echo json_encode($annonces);

}


function modifyCars(){

        $_PUT = json_decode(file_get_contents("php://input"),true);

        if (isset($_PUT['option']) && isset($_PUT['annonce']) && empty($_PUT['addOption']) && empty($_PUT['year'])
                && empty($_PUT['kilometer']) && empty($_PUT['energy']) && empty($_PUT['motor'])
                && empty($_PUT['power']) && empty($_PUT['speedbox']) && empty($_PUT['finish'])) {

                $id = $_PUT['option'];
                $id_annonce = $_PUT['annonce'];
                
                $sql_equipment = "DELETE FROM `list_equipements` WHERE id_equipements = :id AND id_annonces = :id_annonce";

                global $data;
                $statement = $data->prepare($sql_equipment);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->bindParam(':id_annonce', $id_annonce, PDO::PARAM_INT);
                
                if ($statement->execute()) {
                        $sql_equipements ="SELECT equipements.id, equipements.categorie AS categorie , equipements.description AS equipement
                                        FROM list_equipements
                                        INNER JOIN equipements ON list_equipements.id_equipements = equipements.id
                                        WHERE id_annonces LIKE :id";

                        $stmt = $data->prepare($sql_equipements);
                        $stmt->bindParam(":id", $id_annonce, PDO::PARAM_INT);

                        if ($stmt->execute()) {
                                $result['equipements'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                return_json(true, 'Suppression réussi', $result); 
                        }else return_json(false, 'Les equipements ne ce sont pas mis a jour');

                }else return_json(false, 'element non supprime');

        }elseif (isset($_PUT['addOption']) && isset($_PUT['annonce']) && empty($_PUT['year'])
                && empty($_PUT['kilometer']) && empty($_PUT['energy']) && empty($_PUT['motor'])
                && empty($_PUT['power']) && empty($_PUT['speedbox']) && empty($_PUT['finish'])) {

                $id = $_PUT['addOption'];
                $id_annonce = $_PUT['annonce'];
                
                $sql_equipment = "INSERT INTO list_equipements (`id`, `id_annonces`, `id_equipements`)
                                VALUES (NULL, :id_annonce, :id)";

                global $data;
                $statement = $data->prepare($sql_equipment);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->bindParam(':id_annonce', $id_annonce, PDO::PARAM_INT);
                
                if ($statement->execute()) {
                        $sql_equipements ="SELECT equipements.id, equipements.categorie AS categorie , equipements.description AS equipement
                                        FROM list_equipements
                                        INNER JOIN equipements ON list_equipements.id_equipements = equipements.id
                                        WHERE id_annonces LIKE :id";
                        $stmt = $data->prepare($sql_equipements);
                        $stmt->bindParam(":id", $id_annonce, PDO::PARAM_INT);
                        
                        if ($stmt->execute()) {
                                $result['equipements'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                return_json(true, 'option ajouté', $result);
                        }else return_json(false, 'equipements non charge');

                }else return_json(false, 'element non ajouté');

        }elseif (isset($_PUT['annonce']) && isset($_PUT['year']) && isset($_PUT['kilometer']) && isset($_PUT['energy']) && isset($_PUT['motor'])
                && isset($_PUT['power']) && isset($_PUT['speedbox']) && isset($_PUT['finish']) && isset($_PUT['price']) && empty($_PUT['addOption']) && empty($_PUT['option'])) {
                
                $id = $_PUT['annonce'];
                $year = $_PUT['year'];
                $kilometer = $_PUT['kilometer'];
                $energy = $_PUT['energy'];
                $motor = $_PUT['motor'];
                $power = $_PUT['power'];
                $speedbox = $_PUT['speedbox'];
                $finish = $_PUT['finish'];
                $price = $_PUT['price'];


                $sql_modifyCar = "UPDATE annonces 
                        SET id_energies = :energy, prix = :price, kilometrage = :kilometer, annee = :annee, 
                        puissance = :power, boite_vitesse = :speedbox, motorisation = :motor, finition = :finish
                        WHERE numero_annonce LIKE :id";
                
                global $data;

                $statement = $data->prepare($sql_modifyCar);
                $statement->bindParam(':energy', $energy, PDO::PARAM_INT);
                $statement->bindParam(':price', $price, PDO::PARAM_INT);
                $statement->bindParam(':kilometer', $kilometer, PDO::PARAM_INT);
                $statement->bindParam(':annee', $year, PDO::PARAM_INT);
                $statement->bindParam(':power', $power, PDO::PARAM_INT);
                $statement->bindParam(':speedbox', $speedbox, PDO::PARAM_STR);
                $statement->bindParam(':motor', $motor, PDO::PARAM_STR);
                $statement->bindParam(':finish', $finish, PDO::PARAM_STR);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);

                if ($statement->execute()) {
                        $sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, 
                                        energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele
                                        FROM annonces
                                        INNER JOIN energies ON annonces.id_energies = energies.id
                                        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
                                        WHERE annonces.numero_annonce = :id";
                        
                        $stmt = $data->prepare($sql_annonces);
                        $stmt->bindParam(':id', $id);

                        if ($stmt->execute()) {
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                return_json(true, 'annonce mis a jour', $result);

                        }else return_json(false, 'l\'annonce n\'a pu être chargé');

                }else return_json(false, 'Les modifications n\'ont pas été pris en compte');

        }elseif (isset($_PUT['id'])) {

                $id = $_PUT['id'];
                
                global $data;

                $statement = $data->prepare("UPDATE annonces SET status = '1' WHERE numero_annonce = $id");
                
                if ($statement->execute()) {
                        return_json(true, 'Le véhicule à été vendu');
                }
        }
}