<?php

require_once './function.php';
require_once './connection.php';

header('Access-Control-Allow-Origin: *');

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
        addNewImage();
}else return_json(false, "La methode POST est requise");

function addNewImage() {

    if(!empty($_FILES['image'])) {
        if($_FILES['image']['error'] == 0 && is_uploaded_file($_FILES['image']['tmp_name'])) {

            $file_name = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            $chemin_fichier = $_SERVER['DOCUMENT_ROOT']."/src/assets/images/.$file_name";
            if(move_uploaded_file($_FILES['image']['tmp_name'], $chemin_fichier)) {
                return_json(true, 'Fichier enregistré');
            } else {
                return_json(false, 'Erreur lors de l\'enregistrement');
            }
        } else {
            return_json(false, 'Fichier non uploadé');
        }
    }
}