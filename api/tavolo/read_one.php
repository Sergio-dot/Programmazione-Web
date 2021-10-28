<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/tavolo.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$tavolo = new Tavolo($db);

// set id property of record to read
$tavolo->id_tavolo = isset($_GET['id_tavolo']) ? $_GET['id_tavolo'] : die();

// read details of record to be edited
$tavolo->readOne();

if ($tavolo->posti != null) {
    // create array
    $tavolo_arr = array(
        "id_tavolo" => $tavolo->id_tavolo,
        "id_ambiente" => $tavolo->id_ambiente,
        "nome_ambiente" => $tavolo->nome_ambiente,
        "posti" => $tavolo->posti
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($tavolo_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
