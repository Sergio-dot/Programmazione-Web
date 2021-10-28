<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/tipologia.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$tipologia = new Tipologia($db);

// query table
$stmt = $tipologia->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // make a table array
    $tipologia_arr = array();
    $tipologia_arr['records'] = array();

    // retrieve table contents through fetch()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // e.g. this will make $row['x'] to $x
        extract($row);

        $tipologia_item = array(
            'id_tipologia' => $id_tipologia,
            'nome' => $nome
        );
        array_push($tipologia_arr['records'], $tipologia_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show data in json format
    echo json_encode($tipologia_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Non è stato trovato alcun risultato, riprova più tardi."));
}
