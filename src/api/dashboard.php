<?php

use function PHPSTORM_META\type;

require_once './function.php';
require_once './connection.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == 'POST') {
    $_POST = json_decode(file_get_contents("php://input"),true);
        switch ($_POST) {
            case isset($_POST['messages']):
                getMessages();
                break;

            case isset($_POST['utilisateurs']):
                getUsers();
                break;
            
            default:
            return_json(false, "une variable est attendue");
            break;
        }
}else return_json(false, "La methode POST est requise");


function getMessages() {
    try {
        $sql = "SELECT * FROM messages";
        $messages['messages'] = simple_fetch_data($sql);
        $messages['nombres'] = count($messages);

        return_json(true, "messages trouvés", $messages);
    } catch (PDOException $e) {
        return_json(false, "aucuns messages trouvés", $e->getMessage());
    }
}

function getUsers() {
    try {
        $sql = "SELECT nom, prenom, mail, utilisateurs.id, permissions.type AS nom_permissions FROM utilisateurs
        INNER JOIN permissions ON permissions.id = id_permissions";

        global $data;
        $statement = $data->prepare($sql);
        $statement->execute();
        $users['list_permissions'] = $statement->fetchAll(PDO::FETCH_COLUMN, 4);

        $statement->execute();
        $users['utilisateurs'] = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users['nombres'] = count($users['utilisateurs']);

        return_json(true, 'utilisateur trouve', $users);
    } catch (PDOException $e) {
        return_json(false, 'Aucuns utilisateurs trouvés', $e->getMessage());
    }
}