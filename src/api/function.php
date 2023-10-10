<?php
require_once './connection.php';

function return_json($success, $msg, $results=null){
    $return = $results;
    $return["success"] = $success;
    $return["message"] = $msg;

    echo json_encode($return);
}

function simple_fetch_data($sql){
    global $data;
    $statement = $data->prepare($sql);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}