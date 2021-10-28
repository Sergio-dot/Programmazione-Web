<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/dettagli_comanda.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$dettagli_comanda = new dettagliComanda($db);

// set id property of record to read
$dettagli_comanda->id_det_comanda = isset($_GET['id_det_comanda']) ? $_GET['id_det_comanda'] : die();

// read details of record to be edited
$dettagli_comanda->readOne();

if ($dettagli_comanda->id_comanda != null) {
    // create array
    $dettagli_comanda_arr = array(
        "id_det_comanda" => $dettagli_comanda->id_det_comanda,
        "id_comanda" => $dettagli_comanda->id_comanda,
        "id_menu" => $dettagli_comanda->id_menu,
        "stato" => $dettagli_comanda->stato
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($dettagli_comanda_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
