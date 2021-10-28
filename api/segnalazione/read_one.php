<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/segnalazione.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$segnalazione = new Segnalazione($db);

// set id property of record to read
$segnalazione->id_segnalazione = isset($_GET['id_segnalazione']) ? $_GET['id_segnalazione'] : die();

// read details of record to be edited
$segnalazione->readOne();

if ($segnalazione->id_chef != null) {
    // create array
    $segnalazione_arr = array(
        "id_segnalazione" => $segnalazione->id_segnalazione,
        "id_chef" => $segnalazione->id_chef,
        "ingrediente" => $segnalazione->ingrediente
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($segnalazione_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
