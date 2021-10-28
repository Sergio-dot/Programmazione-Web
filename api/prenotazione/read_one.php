<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/prenotazione.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$prenotazione = new Prenotazione($db);

// set id property of record to read
$prenotazione->id_prenotazione = isset($_GET['id_prenotazione']) ? $_GET['id_prenotazione'] : die();

// read details of record to be edited
$prenotazione->readOne();

if ($prenotazione->cognome != null) {
    // create array
    $prenotazione_arr = array(
        "id_prenotazione" => $prenotazione->id_prenotazione,
        "id_tavolo" => $prenotazione->id_tavolo,
        "nome" => $prenotazione->nome,
        "cognome" => $prenotazione->cognome,
        "data_prenotazione" => $prenotazione->data_prenotazione
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($prenotazione_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
