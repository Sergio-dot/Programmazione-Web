<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/segnalazione.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$segnalazione = new Segnalazione($db);

// get id of record to be edited
$data = json_decode(file_get_contents("php://input"));

// set id property of record to be edited
$segnalazione->id_segnalazione = $data->id_segnalazione;

// set property values
$segnalazione->id_chef = $data->id_chef;
$segnalazione->ingrediente = $data->ingrediente;

// update record
if ($segnalazione->update()) {
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
