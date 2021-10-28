<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/prenotazione.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$prenotazione = new Prenotazione($db);

// query table
$stmt = $prenotazione->read();

// make a table array
$prenotazione_arr = array();
$prenotazione_arr['records'] = array();

// retrieve table contents through fetch()
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // e.g. this will make $row['x'] to $x
    extract($row);

    $prenotazione_item = array(
        'id_prenotazione' => $id_prenotazione,
        'id_tavolo' => $id_tavolo,
        'nome' => $nome,
        'cognome' => $cognome,
        'data_prenotazione' => $data_prenotazione
    );
    array_push($prenotazione_arr['records'], $prenotazione_item);
}

// set response code - 200 OK
http_response_code(200);

// show data in json format
echo json_encode($prenotazione_arr);
