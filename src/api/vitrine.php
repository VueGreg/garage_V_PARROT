<?php

require_once './function.php';
require_once './connection.php';

//-----Annonces
$sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, 
        energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele, images.adresse AS photo
        FROM annonces 
        INNER JOIN energies ON annonces.id_energies = energies.id
        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
        INNER JOIN galeries ON galeries.id_annonces = annonces.numero_annonce
        INNER JOIN images ON galeries.id_images = images.id
        GROUP BY numero_annonce";

$annonces = simple_fetch_data($sql_annonces);


//-----Réparations
$sql_reparation = "SELECT * FROM reparations";
$reparations = simple_fetch_data($sql_reparation);

//-----Horaires
$sql_horaires = "SELECT * FROM horaires";
$horaires = simple_fetch_data($sql_horaires);

//-----Images Sites
$sql_images = "SELECT * FROM images WHERE id > 50";
$images = simple_fetch_data($sql_images);


$result["nb_reparation"] = count($reparations);
$result["nb_annonces"] = count($annonces);
$result["annonces"] = $annonces;
$result["reparations"] = $reparations;
$result["horaires"] = $horaires;
$result["images"] = $images;

return_json(true, "200", $result);