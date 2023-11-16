<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'PUT') {
    changeBusinessSetting();
}
elseif ($request_method == 'POST') {
    modifyRepair();
}
else return_json(false, "La methode POST est requise");


function changeBusinessSetting() {
    try{
        $_PUT = json_decode(file_get_contents('php://input'), true);

        if (isset($_PUT['adress']) && isset($_PUT['postal']) && isset($_PUT['city']) && isset($_PUT['tel']) && isset($_PUT['mail']) && empty($_PUT['arr'])) {

            $adress = $_PUT['adress'];
            $postal = $_PUT['postal'];
            $city = $_PUT['city'];
            $tel = $_PUT['tel'];
            $mail = $_PUT['mail'];
            
            $sql = "UPDATE entreprise SET adresse = :adress, code_postal = :postal, 
                    ville = :city, mail = :mail, num_telephone = :tel 
                    WHERE `entreprise`.`id` = 1"; 

            global $data;
            $statement = $data->prepare($sql);
            $statement->bindParam(':adress', $adress);
            $statement->bindParam(':postal', $postal);
            $statement->bindParam(':city', $city);
            $statement->bindParam(':mail', $mail);
            $statement->bindParam(':tel', $tel);

            if ($statement->execute()) {
                return_json(true, 'informations modifiés');
            }
        }
        elseif (isset($_PUT['category']) && isset($_PUT['description']) && empty($_PUT['arr'])) {

            $category = $_PUT['category'];
            $description = $_PUT['description'];

            $sql = "INSERT INTO reparations (`id`, `categorie`, `description`)
                    VALUES (NULL, :category, :description) ";

            global $data;
            $statement = $data->prepare($sql);
            $statement->bindParam(':category', $category);
            $statement->bindParam(':description', $description);

            if ($statement->execute()) {
                return_json(true, 'Nouvelle prestation ajouté');
            }
        }
        elseif(isset($_PUT['arr'])) {

            $arr = $_PUT['arr'];

            global $data;

            for ( $i=1 ; $i < count($arr)+1 ; $i++) { 

                foreach ($arr[$i] as $key => $value) {
                    if ($key == 'debut') {
                        $debut = $value;
                    }
                    elseif ($key == 'fin') {
                        $fin = $value;
                    }
                }

                $sql = "UPDATE horaires SET h_debut = :debut, h_fin = :fin WHERE id = $i";
                $statement = $data->prepare($sql);
                $statement->bindParam(':debut', $debut);
                $statement->bindParam(':fin', $fin);

                if (!$statement->execute()) {
                    return_json(false, 'Modifications non réussies');
                    $i = count($arr) + 1;
                }
                elseif ($i == count($arr)) {
                    return_json(true, 'Modifications réussies');
                }
            }
        }


    }catch (Exception $e){ return_json(false, $e->getMessage());}
}

function modifyRepair () {
    try {
        $_POST = json_decode(file_get_contents('php://input'), true);

        if (isset($_POST['id'])) {

            $id = $_POST['id'];
            
            $sql = "DELETE FROM reparations WHERE id = :id";

            global $data;
            $statement = $data->prepare($sql);
            $statement->bindParam(':id', $id);

            if ($statement->execute()) {
                return_json(true, 'Prestation supprimé');
            }
        }

    }catch (Exception $e){ return_json(false, $e->getMessage());}
}