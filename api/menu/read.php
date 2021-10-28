<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/menu.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$menu = new Menu($db);

// query table
$stmt = $menu->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // make a table array
    $menu_arr = array();
    $menu_arr['records'] = array();

    // retrieve table contents through fetch()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // e.g. this will make $row['x'] to $x
        extract($row);

        $menu_item = array(
            'id_menu' => $id_menu,
            'nome' => $nome,
            'prezzo' => $prezzo
        );
        array_push($menu_arr['records'], $menu_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show data in json format
    echo json_encode($menu_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Non è stato trovato alcun risultato, riprova più tardi."));
}
