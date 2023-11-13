<?php

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'PUT') {
    changeBusinessSetting();
}else return_json(false, "La methode POST est requise");


function changeBusinessSetting() {
    try{
        $_PUT = json_decode(file_get_contents('php://input'), true);

        if (isset($_PUT['adress']) && isset($_PUT['postal']) && isset($_PUT['city']) && isset($_PUT['tel']) && isset($_PUT['mail'])) {

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


    }catch (Exception $e){ return_json(false, $e->getMessage());}
}