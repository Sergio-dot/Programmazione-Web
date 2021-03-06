<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/projects/programmazione_web/api");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/utente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate product object
$utente = new Utente($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set utente property values
$utente->ruolo = $data->ruolo;
$utente->id = $data->id;

if ($utente->delete()) {
    // set response code
    http_response_code(200);

    // display successful message
    echo json_encode(array("message" => "L'account è stato eliminato."));
}

// if unable to delete user
else {
    // set response code
    http_response_code(400);

    // display error message
    echo json_encode(array("message" => "Non è stato possibile eliminare l'account."));
}
