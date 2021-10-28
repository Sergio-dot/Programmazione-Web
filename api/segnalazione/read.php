<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/segnalazione.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$segnalazione = new Segnalazione($db);

// query table
$stmt = $segnalazione->read();

// make a table array
$segnalazione_arr = array();
$segnalazione_arr['records'] = array();

// retrieve table contents through fetch()
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // e.g. this will make $row['x'] to $x
    extract($row);

    $segnalazione_item = array(
        'id_segnalazione' => $id_segnalazione,
        'id_chef' => $id_chef,
        'id_ingrediente' => $id_ingrediente,
        'ingrediente' => $ingrediente
    );
    array_push($segnalazione_arr['records'], $segnalazione_item);
}

// set response code - 200 OK
http_response_code(200);

// show data in json format
echo json_encode($segnalazione_arr);
