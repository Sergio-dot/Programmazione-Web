<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/prenotazione.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$prenotazione = new Prenotazione($db);

// get id of record to be edited
$data = json_decode(file_get_contents("php://input"));

// set id property of record to be edited
$prenotazione->id_prenotazione = $data->id_prenotazione;

// set property values
$prenotazione->id_tavolo = $data->id_tavolo;
$prenotazione->nome = $data->nome;
$prenotazione->cognome = $data->cognome;
$prenotazione->data_prenotazione = $data->data_prenotazione;

// update record
if ($prenotazione->update()) {
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
