<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/dettagli_comanda.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$dettagli_comanda = new dettagliComanda($db);

// query table
$stmt = $dettagli_comanda->read();

// make a table array
$dettagli_comanda_arr = array();
$dettagli_comanda_arr['records'] = array();

// retrieve table contents through fetch()
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // e.g. this will make $row['x'] to $x
    extract($row);

    $dettagli_comanda_item = array(
        "id_det_comanda" => $id_det_comanda,
        "id_comanda" => $id_comanda,
        "id_tavolo" => $id_tavolo,
        "id_menu" => $id_menu,
        "nome" => $nome,
        "prezzo" => $prezzo,
        "stato" => $stato
    );
    array_push($dettagli_comanda_arr['records'], $dettagli_comanda_item);
}

// set response code - 200 OK
http_response_code(200);

// show data in json format
echo json_encode($dettagli_comanda_arr);
