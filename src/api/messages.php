<?php

use function PHPSTORM_META\type;

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
        getMessages();
}else return_json(false, "La methode POST est requise");


function getMessages() {

        $_GET = json_decode(file_get_contents("php://input"),true);

        if (empty($_GET)) {

            $sql = "SELECT * FROM messages";
            $messages['messages'] = simple_fetch_data($sql);

            $messages['nombres'] = count($messages);
        }

echo json_encode($messages);

}