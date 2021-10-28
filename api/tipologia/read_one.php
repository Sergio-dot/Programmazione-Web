<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/tipologia.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$tipologia = new Tipologia($db);

// set id property of record to read
$tipologia->id_tipologia = isset($_GET['id_tipologia']) ? $_GET['id_tipologia'] : die();

// read details of record to be edited
$tipologia->readOne();

if ($tipologia->nome != null) {
    // create array
    $tipologia_arr = array(
        "id_tipologia" => $tipologia->id_tipologia,
        "nome" => $tipologia->nome
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($tipologia_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
