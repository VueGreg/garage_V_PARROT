<?php

require_once './function.php';
require_once './connection.php';

if (empty($_GET)) {

        $sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, 
        energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele
        FROM annonces
        INNER JOIN energies ON annonces.id_energies = energies.id
        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
        INNER JOIN galeries ON galeries.id_annonces = numero_annonce";

        $annonces = simple_fetch_data($sql_annonces);

        foreach ($annonces as $key => $value) {

                $id = $annonces[$key]['numero_annonce'];

                $sql_photos =  "SELECT images.adresse AS photo 
                                FROM galeries
                                INNER JOIN images ON galeries.id_images = images.id
                                WHERE id_annonces LIKE :id
                                LIMIT 1";

                $stmt = $data->prepare($sql_photos);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                $annonces[$key]["photo"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $message = "Tous les vehicules";

}else if (isset($_GET['annonce']) || (isset($_GET['minyear']) && isset($_GET['maxyear']) && isset($_GET['minkilometer']) && isset($_GET['maxkilometer'])
                && isset($_GET['mark']) && isset($_GET['model']) && isset($_GET['energy']) && isset($_GET['minprice']) && isset($_GET['maxprice'])))
        
        {
      
        $sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, 
        energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele
        FROM annonces
        INNER JOIN energies ON annonces.id_energies = energies.id
        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
        WHERE numero_annonce LIKE :annonce 
        OR (
                annee BETWEEN :minyear AND :maxyear
                AND kilometrage BETWEEN :minkilometer AND :maxkilometer
                AND marque LIKE :mark
                AND modele LIKE :model
                AND energies.nom LIKE :energy
                AND prix BETWEEN :minprice AND :maxprice
        )";

        //Remplacer les valeurs vide par une valeur traitable par BETWEEN
        if (empty($_GET['minyear'])) {
               $_GET['minyear'] = 1900;
        }


        if (empty($_GET['maxyear'])) {
                $currentDate = new DateTime();
                $_GET['maxyear'] = $currentDate->format("Y");
        }

        if (empty($_GET['minkilometer'])) {
                $_GET['minkilometer'] = 0;
        }

        if (empty($_GET['maxkilometer'])) {
                $_GET['maxkilometer'] = 500000;
        }

        if (empty($_GET['mark'])) {
                $_GET['mark'] = "%";
        }

        if (empty($_GET['model'])) {
                $_GET['model'] = "%";
        }

        if (empty($_GET['energy'])) {
                $_GET['energy'] = "%";
        }

        if (empty($_GET['minprice'])) {
                $_GET['minprice'] = 0;
        }

        if (empty($_GET['maxprice'])) {
                $_GET['maxprice'] = 500000;
        }

        global $data;
        $statement = $data->prepare($sql_annonces);
        $statement-> bindParam(":annonce", $_GET['annonce']);
        $statement-> bindParam(":minyear", $_GET['minyear']);
        $statement-> bindParam(":maxyear", $_GET['maxyear']);
        $statement-> bindParam(":minkilometer", $_GET['minkilometer']);
        $statement-> bindParam(":maxkilometer", $_GET['maxkilometer']);
        $statement-> bindParam(":mark", $_GET['mark']);
        $statement-> bindParam(":model", $_GET['model']);
        $statement-> bindParam(":energy", $_GET['energy']);
        $statement-> bindParam(":minprice", $_GET['minprice']);
        $statement-> bindParam(":maxprice", $_GET['maxprice']);
        $statement->execute();

        $annonces = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Parcour du tableau pour définir les équipements et images
        foreach ($annonces as $key => $value) {

                $id = $annonces[$key]['numero_annonce'];

                $sql_equipements ="SELECT equipements.categorie AS categorie , equipements.description AS equipement
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

                $message = $_GET;
        }
} else $message = "variables non renseigné";

return_json(true, $message, $annonces);