<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/comanda.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$comanda = new Comanda($db);

// set id property of record to read
$comanda->id_comanda = isset($_GET['id_comanda']) ? $_GET['id_comanda'] : die();

// read details of record to be edited
$comanda->readOne();

if ($comanda->data_creazione != null) {
    // create array
    $comanda_arr = array(
        "id_comanda" => $comanda->id_comanda,
        "id_tavolo" => $comanda->id_tavolo,
        "data_creazione" => $comanda->data_creazione,
        "ultima_modifica" => $comanda->ultima_modifica
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($comanda_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
