<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/comanda.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$comanda = new Comanda($db);

// query table
$stmt = $comanda->read();

// make a table array
$comanda_arr = array();
$comanda_arr['records'] = array();

// retrieve table contents through fetch()
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // e.g. this will make $row['x'] to $x
    extract($row);

    $comanda_item = array(
        "id_comanda" => $id_comanda,
        "id_tavolo" => $id_tavolo,
        "data_creazione" => $data_creazione,
        "ultima_modifica" => $ultima_modifica
    );
    array_push($comanda_arr['records'], $comanda_item);
}

// set response code - 200 OK
http_response_code(200);

// show data in json format
echo json_encode($comanda_arr);
