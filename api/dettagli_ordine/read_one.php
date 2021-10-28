<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/dettagli_ordine.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$dettagli_ordine = new dettagliOrdine($db);

// set id property of record to read
$dettagli_ordine->id_dettagli = isset($_GET['id_dettagli']) ? $_GET['id_dettagli'] : die();

// read details of record to be edited
$dettagli_ordine->readOne();

if ($dettagli_ordine->id_ordine != null) {
    // create array
    $dettagli_ordine_arr = array(
        "id_dettagli" => $dettagli_ordine->id_dettagli,
        "id_ordine" => $dettagli_ordine->id_ordine,
        "id_ingrediente" => $dettagli_ordine->id_ingrediente,
        "quantita" => $dettagli_ordine->quantita
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($dettagli_ordine_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
