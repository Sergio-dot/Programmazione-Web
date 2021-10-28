<?php

// require headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/ingrediente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$ingrediente = new Ingrediente($db);

// query table
$stmt = $ingrediente->read();

// make a table array
$ingrediente_arr = array();
$ingrediente_arr['records'] = array();

// retrieve table contents through fetch()
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // e.g. this will make $row['x'] to $x
    extract($row);

    $ingrediente_item = array(
        'id_ingrediente' => $id_ingrediente,
        'id_categoria' => $id_categoria,
        'id_ambiente' => $id_ambiente,
        'nome' => $nome,
        'quantita' => $quantita
    );
    array_push($ingrediente_arr['records'], $ingrediente_item);
}

// set response code - 200 OK
http_response_code(200);

// show data in json format
echo json_encode($ingrediente_arr);
