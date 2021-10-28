<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/ordine.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ordine = new Ordine($db);

// query table
$stmt = $ordine->maxId();

// make a table array
$ordine_arr = array();
$ordine_arr['records'] = array();

// retrieve table contents through fetch()
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // e.g. this will make $row['x'] to $x
    extract($row);

    $ordine_item = array(
        'id_ordine' => $id_ordine
    );
    array_push($ordine_arr['records'], $ordine_item);
}

// set response code - 200 OK
http_response_code(200);

// show data in json format
echo json_encode($ordine_arr);
