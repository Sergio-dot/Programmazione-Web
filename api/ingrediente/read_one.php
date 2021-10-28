<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/ingrediente.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ingrediente = new Ingrediente($db);

// set id property of record to read
$ingrediente->id_ingrediente = isset($_GET['id_ingrediente']) ? $_GET['id_ingrediente'] : die();

// read details of record to be edited
$ingrediente->readOne();

if ($ingrediente->nome != null) {
    // create array
    $ingrediente_arr = array(
        "id_ingrediente" => $ingrediente->id_ingrediente,
        "id_categoria" => $ingrediente->id_categoria,
        "id_ambiente" => $ingrediente->id_ambiente,
        "nome" => $ingrediente->nome,
        "quantita" => $ingrediente->quantita
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($ingrediente_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
