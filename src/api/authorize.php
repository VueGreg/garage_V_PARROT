<?php

use function PHPSTORM_META\type;

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
        getAuthorized();
}else return_json(false, "La methode POST est requise");


function getAuthorized() {

        try {

                $_GET = json_decode(file_get_contents("php://input"),true);

                if (isset($_GET['permissions'])) {

                $sql = "SELECT utilisateurs.token, permissions.rang AS p_rank 
                        FROM utilisateurs
                        INNER JOIN permissions ON permissions.id = id_permissions
                        WHERE utilisateurs.token LIKE :permissions";

                global $data;

                $statement = $data->prepare($sql);
                $statement->bindParam(':permissions', $_GET['permissions'], PDO::PARAM_STR);
                $statement->execute();
                $result = $statement-> fetch(PDO::FETCH_ASSOC);
                $rank['rang'] = $result['p_rank'];

                        if ($result['token'] == $_GET['permissions']) {
                                return_json(true, 'autorized', $rank);
                        }else return_json(false, 'nok', $rank);
                }

        } catch (PDOException $e) {return_json(false, $e->getMessage());}

}