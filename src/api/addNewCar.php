<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
        addNewCar();
}else return_json(false, "La methode POST est requise");

function addNewCar() {

    try {
        if (isset($_POST['vehicle']) && isset($_POST['energy']) && isset($_POST['price']) && isset($_POST['kilometer']) && isset($_POST['year']) 
        && isset($_POST['power']) && isset($_POST['speedbox']) && isset($_POST['motor']) && isset($_POST['finish']) && isset($_POST['equipments'])
        && isset($_FILES['image'])) {
            
            $vehicle = $_POST['vehicle'];
            $energy = $_POST['energy'];
            $price = $_POST['price'];
            $kilometer = $_POST['kilometer'];
            $year = $_POST['year'];
            $power = $_POST['power'];
            $speedbox = $_POST['speedbox'];
            $motor = $_POST['motor'];
            $finish = $_POST['finish'];
            $equipments = preg_split("/[\s,]+/", $_POST['equipments']);

            $sql = "INSERT INTO annonces (`numero_annonce`, `id_vehicules`, `id_energies`, `prix`, `kilometrage`, `annee`, `puissance`, `boite_vitesse`, `motorisation`, `finition`, `status`)
                    VALUES (NULL, :vehicle, :energy, :price, :kilometer, :year, :power, :speedbox, :motor, :finish, 0)";

            global $data;
            $statement = $data->prepare($sql);
            $statement->bindParam(':vehicle', $vehicle);
            $statement->bindParam(':energy', $energy);
            $statement->bindParam(':price', $price);
            $statement->bindParam(':kilometer', $kilometer);
            $statement->bindParam(':year', $year);
            $statement->bindParam(':power', $power);
            $statement->bindParam(':speedbox', $speedbox);
            $statement->bindParam(':motor', $motor);
            $statement->bindParam(':finish', $finish);

            if ($statement->execute()) {
                $id = $data->lastInsertId();

                foreach ($equipments as $equipment) {
                    $sql_options = "INSERT INTO list_equipements (`id`, `id_annonces`, `id_equipements`)
                                    VALUES (NULL, :id, :equipment)";
                
                    $stmt = $data->prepare($sql_options);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':equipment', $equipment);
                    $stmt->execute();
                }

                if(!empty($_FILES['image'])) {

                    foreach ($_FILES['image']['error'] as $key => $error) {

                        if($error == 0 && is_uploaded_file($_FILES['image']['tmp_name'][$key])) {
            
                            $file_name = $_FILES['image']['name'][$key];
                            $tmp_name = $_FILES['image']['tmp_name'][$key];
                            $adresse = "http://localhost/src/assets/images/.$file_name";
                            $nom = "Photo du véhicule";
                
                            $chemin_fichier = $_SERVER['DOCUMENT_ROOT']."/src/assets/images/.$file_name";
    
                            if (!file_exists($chemin_fichier)) {
    
                                if(move_uploaded_file($tmp_name, $chemin_fichier)) {
                                
                                    $sql_image = "INSERT INTO images (`id`, `adresse`, `nom`, `alt`) 
                                                  VALUES (NULL, :adress, :nom, :alt)";
        
                                    $stment = $data->prepare($sql_image);
                                    $stment->bindParam(':adress', $adresse);
                                    $stment->bindParam(':nom', $nom);
                                    $stment->bindParam(':alt', $nom);
        
                                    if ($stment->execute()) {
        
                                        $id_image = $data->lastInsertId();
                                        
                                        $sql_galerie = "INSERT INTO galeries (`id`, `id_images`, `id_annonces`)
                                                        VALUES (NULL, :id_image, :id)";
                                        
                                        $st= $data->prepare($sql_galerie);
                                        $st->bindParam(':id_image', $id_image);
                                        $st->bindParam(':id', $id);
        
                                        if ($st->execute()) {
                                            return_json(true, 'insertion complete');
                                        }
        
                                    } else return_json(false, 'image non enregistre dans la BDD');
                    
                                } else return_json(false, 'Erreur lors de l\'enregistrement');
    
                            }else return_json(false, 'L\'image existe deja');
                            
                        } else {
                            return_json(false, 'Fichier non uploadé');
                        }
                    }
                    
                }else return_json(false, 'Pas de file image');

            } else return_json(false, "Annonces non insere");

        }else return_json(false, "Un parametre est manquant");
    } 
    catch (PDOException $e) {
       return_json(false, $e->getMessage());
    }
}