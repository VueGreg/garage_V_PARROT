<?php
require_once './function.php';
require_once '../../Dotenv.php';

header('Content-Type: application/json');

$host = $_ENV['DATABASE_HOST'];
$dbname = $_ENV['DATABASE_DBNAME'];
$user = $_ENV['DATABASE_USER'];
$password = $_ENV['DATABASE_PASSWORD'];

try {
    $data = new PDO('mysql:host='.$host.';dbname='.$dbname.';', $user, $password);

} catch (PDOException $e) {
    return_json(false, $e->getMessage());
}