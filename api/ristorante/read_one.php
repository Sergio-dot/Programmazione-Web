<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/ristorante.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ristorante = new Ristorante($db);

// set id property of record to read
$ristorante->id_ristorante = isset($_GET['id_ristorante']) ? $_GET['id_ristorante'] : die();

// read details of record to be edited
$ristorante->readOne();

if ($ristorante->nome != null) {
    // create array
    $ristorante_arr = array(
        "id_ristorante" => $ristorante->id_ristorante,
        "nome" => $ristorante->nome,
        "telefono" => $ristorante->telefono,
        "indirizzo" => $ristorante->indirizzo
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($ristorante_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database.")
    );
}
