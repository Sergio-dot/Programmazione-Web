<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/categoria.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$categoria = new Categoria($db);

// set id property of record to read
$categoria->id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : die();

// read details of record to be edited
$categoria->readOne();

if ($categoria->nome != null) {
    // create array
    $categoria_arr = array(
        "id_categoria" => $categoria->id_categoria,
        "nome" => $categoria->nome
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($categoria_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
