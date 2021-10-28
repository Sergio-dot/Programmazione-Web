<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/dettagli_comanda.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$dettagli_comanda = new dettagliComanda($db);

// get id of record to be edited
$data = json_decode(file_get_contents("php://input"));

// set id property of record to be edited
$dettagli_comanda->id_det_comanda = $data->id_det_comanda;

// set property values
$dettagli_comanda->id_comanda = $data->id_comanda;
$dettagli_comanda->id_menu = $data->id_menu;
$dettagli_comanda->stato = $data->stato;

// update record
if ($dettagli_comanda->update()) {
    // set response code - 200 OK
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Modifiche applicate con successo."));
}

// if unable to update
else {
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Servizio non disponibile, riprovare più tardi."));
}
