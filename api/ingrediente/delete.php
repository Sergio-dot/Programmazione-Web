<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/ingrediente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ingrediente = new Ingrediente($db);

// get record id
$data = json_decode(file_get_contents("php://input"));

// set record id to be deleted
$ingrediente->id_ingrediente = $data->id_ingrediente;

// delete record
if ($ingrediente->delete()) {
    // set response code - 200 OK
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Operazione eseguita con successo."));
}

// if unable to delete record
else {
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Servizio non disponibile."));
}
