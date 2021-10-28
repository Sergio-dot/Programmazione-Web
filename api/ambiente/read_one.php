<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/ambiente.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ambiente = new Ambiente($db);

// set id property of record to read
$ambiente->id_ambiente = isset($_GET['id_ambiente']) ? $_GET['id_ambiente'] : die();

// read details of record to be edited
$ambiente->readOne();

if ($ambiente->nome != null) {
    // create array
    $ambiente_arr = array(
        "id_ambiente" => $ambiente->id_ambiente,
        "id_ristorante" => $ambiente->id_ristorante,
        "nome_ristorante" => $ambiente->nome_ristorante,
        "id_tipologia" => $ambiente->id_tipologia,
        "nome_tipologia" => $ambiente->nome_tipologia,
        "nome" => $ambiente->nome
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($ambiente_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
