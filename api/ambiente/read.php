<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/ambiente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ambiente = new Ambiente($db);

// query table
$stmt = $ambiente->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // make a table array
    $ambiente_arr = array();
    $ambiente_arr['records'] = array();

    // retrieve table contents through fetch()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // e.g. this will make $row['x'] to $x
        extract($row);

        $ambiente_item = array(
            'id_ambiente' => $id_ambiente,
            'id_ristorante' => $id_ristorante,
            'id_tipologia' => $id_tipologia,
            'nome' => $nome,
            'nome_ristorante' => $nome_ristorante,
            'nome_tipologia' => $nome_tipologia
        );
        array_push($ambiente_arr['records'], $ambiente_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show data in json format
    echo json_encode($ambiente_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Non è stato trovato alcun risultato."));
}
