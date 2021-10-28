<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/ambiente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ambiente = new Ambiente($db);

// get id of record to be edited
$data = json_decode(file_get_contents("php://input"));

// set id property of record to be edited
$ambiente->id_ambiente = $data->id_ambiente;

// set property values
$ambiente->id_ristorante = $data->id_ristorante;
$ambiente->id_tipologia = $data->id_tipologia;
$ambiente->nome = $data->nome;

// update record
if ($ambiente->update()) {
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
    echo json_encode(array("message" => "Servizio non disponibile, riprova più tardi."));
}
