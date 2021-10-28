<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/dettagli_ordine.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$dettagli_ordine = new dettagliOrdine($db);

// query table
$stmt = $dettagli_ordine->read();

// make a table array
$dettagli_ordine_arr = array();
$dettagli_ordine_arr['records'] = array();

// retrieve table contents through fetch()
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // e.g. this will make $row['x'] to $x
    extract($row);

    $dettagli_ordine_item = array(
        'id_det_ordine' => $id_det_ordine,
        'id_ordine' => $id_ordine,
        'id_ingrediente' => $id_ingrediente,
        'quantita' => $quantita
    );
    array_push($dettagli_ordine_arr['records'], $dettagli_ordine_item);
}

// set response code - 200 OK
http_response_code(200);

// show data in json format
echo json_encode($dettagli_ordine_arr);
