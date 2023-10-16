<?php

require_once './function.php';
require_once './connection.php';


        //-----Images Sites
        $sql_images = "SELECT * FROM images WHERE id > 50";
        $images = simple_fetch_data($sql_images);

        //-----Réparations
        $sql_reparation = "SELECT * FROM reparations";
        $reparations = simple_fetch_data($sql_reparation);

        //-----Horaires
        $sql_horaires = "SELECT * FROM horaires";
        $horaires = simple_fetch_data($sql_horaires);

        //-----informations entreprise
        $sql_infos = "SELECT * FROM entreprise";
        $informations = simple_fetch_data($sql_infos);

        //-----Témoignages
        $sql_temoignages = "SELECT * FROM temoignages";
        $temoignages = simple_fetch_data($sql_temoignages);


        //-----Annonces
        if (empty($_GET["annonce"])) {
                $sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, 
                energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele, images.adresse AS photo
                FROM annonces 
                INNER JOIN energies ON annonces.id_energies = energies.id
                INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
                INNER JOIN galeries ON galeries.id_annonces = annonces.numero_annonce
                INNER JOIN images ON galeries.id_images = images.id
                GROUP BY numero_annonce";

                $annonces = simple_fetch_data($sql_annonces);

                $result["nb_reparation"] = count($reparations);
                $result["nb_annonces"] = count($annonces);
                $result["annonces"] = $annonces;
                $result["reparations"] = $reparations;
                $result["horaires"] = $horaires;
                $result["informations"] = $informations;
                $result["temoignages"] = $temoignages;
                $result["images"] = $images;

                return_json(true, "200", $result);

        }elseif (isset($_GET["annonce"])) {
                
                $sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, 
                energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele
                FROM annonces
                INNER JOIN energies ON annonces.id_energies = energies.id
                INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
                INNER JOIN galeries ON galeries.id_annonces = annonces.numero_annonce
                WHERE numero_annonce LIKE :annonce
                GROUP BY numero_annonce";

                global $data;
                $statement = $data->prepare($sql_annonces);
                $statement-> bindParam(":annonce", $_GET['annonce']);
                $statement->execute();

                $annonces["infos"] = $statement->fetchAll(PDO::FETCH_ASSOC);

                $sql_equipements ="SELECT equipements.categorie AS categorie , equipements.description AS equipement
                                FROM list_equipements
                                INNER JOIN equipements ON list_equipements.id_equipements = equipements.id
                                WHERE id_annonces LIKE :id";
                $stmt = $data->prepare($sql_equipements);
                $stmt->bindParam(":id", $_GET['annonce']);
                $stmt->execute();

                $annonces["equipement"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $sql_photos =  "SELECT images.adresse AS photo 
                                FROM galeries
                                INNER JOIN images ON galeries.id_images = images.id
                                WHERE id_annonces LIKE :id";

                $stmt = $data->prepare($sql_photos);
                $stmt->bindParam(":id", $_GET['annonce']);
                $stmt->execute();

                $annonces["images"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return_json(true, "200", $annonces);
        }