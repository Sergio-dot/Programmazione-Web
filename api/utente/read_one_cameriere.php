<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/utente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare utente object
$utente = new Utente($db);

// set ID property of record to read
$utente->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of utente to be edited
$utente->read_one_cameriere();

if ($utente->nome != null) {
    // create array
    $utente_arr = array(
        "id" =>  $utente->id,
        "id_ristorante" => $utente->id_ristorante,
        "nome_ristorante" => $utente->nome_ristorante,
        "nome" => $utente->nome,
        "cognome" => $utente->cognome,
        "email" => $utente->email,
        "data_nascita" => $utente->data_nascita

    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($utente_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user utente does not exist
    echo json_encode(array("message" => "Utente non esistente."));
}
