<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/menu.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$menu = new Menu($db);

// set id property of record to read
$menu->id_menu = isset($_GET['id_menu']) ? $_GET['id_menu'] : die();

// read details of record to be edited
$menu->readOne();

if ($menu->nome != null) {
    // create array
    $menu_arr = array(
        "id_menu" => $menu->id_menu,
        "nome" => $menu->nome,
        "prezzo" => $menu->prezzo
    );
    // set response code to 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($menu_arr);
} else {
    // set response code to 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(
        array("message" => "L'elemento cercato non è presente nel database")
    );
}
