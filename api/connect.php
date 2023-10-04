<?php
header('Content-Type: application/json');

$dsn = 'mysql:dbname=v_parrot;host=localhost';
$user = 'root';
$password = 'root';
$response = [];
$result = [];
$nb_annonces = null;

try {
    $data = new PDO($dsn, $user, $password);
    $result["success"] = true;
    $result["message"] = "connexion etablie";
} catch (PDOException $e) {
    $result["success"] = false;
    $result["message"] = "connexion non etablie";
}

$sql = "SELECT * FROM annonces";
$statement = $data->prepare($sql);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    array_push($response, $row);
    $nb_annonces++;
}

$result["nb_annonces"] = $nb_annonces;
$result["annonces"] = $response;

echo json_encode($result);