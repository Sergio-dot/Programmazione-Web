<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/comanda.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$comanda = new Comanda($db);

// get id of record to be edited
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->id_tavolo)
) {
    // set property values
    $comanda->id_tavolo = $data->id_tavolo;

    // create new record
    if ($comanda->create()) {
        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Operazione eseguita con successo."));
    }
    // if unable to add new record
    else {
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Servizio non disponibile."));
    }
}

// if data is empty
else {
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Errore nei dati."));
}
