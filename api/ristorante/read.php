<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/ristorante.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ristorante = new Ristorante($db);

// query table
$stmt = $ristorante->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // make a table array
    $ristorante_arr = array();
    $ristorante_arr['records'] = array();

    // retrieve table contents through fetch()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // e.g. this will make $row['x'] to $x
        extract($row);

        $ristorante_item = array(
            'id_ristorante' => $id_ristorante,
            'nome' => $nome,
            'telefono' => $telefono,
            'indirizzo' => $indirizzo
        );
        array_push($ristorante_arr['records'], $ristorante_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show data in json format
    echo json_encode($ristorante_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Non è stato trovato alcun risultato."));
}
