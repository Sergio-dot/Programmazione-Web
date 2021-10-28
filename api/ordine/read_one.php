<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/ordine.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ordine = new Ordine($db);

// set id property of record to read
$ordine->id_ordine = isset($_GET['id_ordine']) ? $_GET['id_ordine'] : die();

// read details of record to be edited
$ordine->readOne();

if ($ordine->id_fornitore != null) {
    // create array
    $ordine_arr = array(
        "id_ordine" => $ordine->id_ordine,
        "id_fornitore" => $ordine->id_fornitore,
        "stato" => $ordine->stato
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($ordine_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
