<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/genere.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$genere = new Genere($db);

// set id property of record to read
$genere->id_genere = isset($_GET['id_genere']) ? $_GET['id_genere'] : die();

// read details of record to be edited
$genere->readOne();

if ($genere->nome != null) {
    // create array
    $genere_arr = array(
        "id_genere" => $genere->id_genere,
        "nome" => $genere->nome
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($genere_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
