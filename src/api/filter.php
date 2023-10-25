<?php

require_once './function.php';
require_once './connection.php';

if (empty($_GET)) {
        $sql_marques = "SELECT DISTINCT vehicules.marque AS marque 
        FROM annonces
        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id";

        $sql_modeles = "SELECT DISTINCT vehicules.modele AS modele
                FROM annonces
                INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id";

        $sql_energies = "SELECT DISTINCT energies.nom AS energie
                FROM annonces
                INNER JOIN energies ON annonces.id_energies = energies.id";

        $sql_annees_min =   "SELECT DISTINCT MIN(annee) FROM annonces";
        $sql_annees_max =   "SELECT DISTINCT MAX(annee) FROM annonces";
        $sql_kilometre_min =   "SELECT DISTINCT MIN(kilometrage) FROM annonces";
        $sql_kilometre_max =   "SELECT DISTINCT MAX(kilometrage) FROM annonces";
        $sql_prix_min =   "SELECT DISTINCT MIN(prix) FROM annonces";
        $sql_prix_max =   "SELECT DISTINCT MAX(prix) FROM annonces";


        global $data;

        $statement = $data->prepare($sql_marques);
        $statement->execute();
        $marques = $statement->fetchAll(PDO::FETCH_COLUMN);


        $statement = $data->prepare($sql_modeles);
        $statement->execute();
        $modeles = $statement->fetchAll(PDO::FETCH_COLUMN);

        $statement = $data->prepare($sql_energies);
        $statement->execute();
        $energies = $statement->fetchAll(PDO::FETCH_COLUMN);


        $statement = $data->prepare($sql_annees_min);
        $statement->execute();
        $annee_min = $statement->fetch(PDO::FETCH_COLUMN);


        $statement = $data->prepare($sql_annees_max);
        $statement->execute();
        $annee_max = $statement->fetch(PDO::FETCH_COLUMN);

        $statement = $data->prepare($sql_kilometre_min);
        $statement->execute();
        $kilometre_min = $statement->fetch(PDO::FETCH_COLUMN);

        $statement = $data->prepare($sql_kilometre_max);
        $statement->execute();
        $kilometre_max = $statement->fetch(PDO::FETCH_COLUMN);

        $statement = $data->prepare($sql_prix_min);
        $statement->execute();
        $prix_min = $statement->fetch(PDO::FETCH_COLUMN);

        $statement = $data->prepare($sql_prix_max);
        $statement->execute();
        $prix_max = $statement->fetch(PDO::FETCH_COLUMN);

} elseif (isset($_GET['mark'])) {
        $sql_modeles = "SELECT vehicules.modele AS modele, energies.nom AS energie
                        FROM annonces
                        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
                        INNER JOIN energies ON annonces.id_energies = energies.id
                        WHERE vehicules.marque LIKE :mark";

        global $data;

        $statement = $data->prepare($sql_modeles);
        $statement->bindParam(':mark', $_GET['mark']);
        $statement->execute();
        $modeles = $statement->fetchall(PDO::FETCH_COLUMN);
        $statement->execute();
        $energies = $statement->fetchall(PDO::FETCH_COLUMN, 1);
        $marques = $_GET['mark'];

}elseif (isset($_GET['model'])) {
        $sql_modeles = "SELECT vehicules.marque AS marque, energies.nom AS energie
                        FROM annonces
                        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id
                        INNER JOIN energies ON annonces.id_energies = energies.id
                        WHERE vehicules.modele LIKE :model";

        global $data;

        $statement = $data->prepare($sql_modeles);
        $statement->bindParam(':model', $_GET['model']);
        $statement->execute();
        $marques = $statement->fetchall(PDO::FETCH_COLUMN);
        $statement->execute();
        $energies = $statement->fetchall(PDO::FETCH_COLUMN, 1);
        $modeles = $_GET['model'];
}

        $result["marque"] = $marques;
        $result["modele"] = $modeles;
        $result["energie"] = $energies;
        $result["annee_min"] = $annee_min;
        $result["annee_max"] = $annee_max;
        $result["kilometre_min"] = $kilometre_min;
        $result["kilometre_max"] = $kilometre_max;
        $result["prix_min"] = $prix_min;
        $result["prix_max"] = $prix_max;
        
return_json(true, "200", $result);
