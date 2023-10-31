<?php

use function PHPSTORM_META\type;

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
        getAuthorized();
}else return_json(false, "La methode POST est requise");


function getAuthorized() {

        $_GET = json_decode(file_get_contents("php://input"),true);

        if (isset($_GET['permissions'])) {

            $sql = "SELECT token FROM utilisateurs WHERE token LIKE :permissions";
            global $data;

            $statement = $data->prepare($sql);
            $statement->bindParam(':permissions', $_GET['permissions']);
            $statement->execute();
            $result = $statement-> fetch(PDO::FETCH_COLUMN);

            if ($result == $_GET['permissions']) {
                return_json(true, 'autorized');
            }else return_json(false, 'nok', $result);
        }

}