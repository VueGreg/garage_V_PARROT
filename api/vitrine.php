<?php
header('Content-Type: application/json');

$dsn = 'mysql:dbname=v_parrot;host=localhost';
$user = 'root';
$password = 'root';
$response = [];
$result = [];
$reparations = [];
$horaires = [];
$nb_annonces = null;
$nb_reparations = null;

try {
    $data = new PDO($dsn, $user, $password);
    $result["success"] = true;
} catch (PDOException $e) {
    $result["success"] = false;
    $result["message"] = $e->getMessage();
}

//-----Annonces
$sql_annonces = "SELECT numero_annonce, prix, kilometrage, annee, puissance, boite_vitesse, motorisation, finition, 
        energies.nom AS energie, vehicules.marque AS marque, vehicules.modele AS modele, images.adresse AS photo
        FROM annonces 
        INNER JOIN energies ON annonces.id_energies = energies.id
        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
        INNER JOIN galeries ON galeries.id_annonces = annonces.numero_annonce
        INNER JOIN images ON galeries.id_images = images.id
        GROUP BY numero_annonce";

$statement = $data->prepare($sql_annonces);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    array_push($response, $row);
    $nb_annonces++;
}

//-----Réparations
$sql_reparation = "SELECT * FROM reparations";

$statement = $data->prepare($sql_reparation);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    array_push($reparations, $row);
    $nb_reparations++;
}

//-----Horaires
$sql_horaires = "SELECT * FROM horaires";

$statement = $data->prepare($sql_horaires);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    array_push($horaires, $row);
}

$result["nb_reparation"] = $nb_reparations;
$result["nb_annonces"] = $nb_annonces;
$result["annonces"] = $response;
$result["reparations"] = $reparations;
$result["horaires"] = $horaires;

echo json_encode($result);