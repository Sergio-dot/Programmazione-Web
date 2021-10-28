<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// include database and object files
include_once '../config/database.php';
include_once '../objects/comanda.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$comanda = new Comanda($db);

// set id property of record to read
$comanda->id_comanda = isset($_GET['id_comanda']) ? $_GET['id_comanda'] : die();

// query table
$stmt = $comanda->read_dettagli();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // make a table array
    $comanda_arr = array();
    $comanda_arr['records'] = array();

    // retrieve table contents through fetch()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // e.g. this will make $row['x'] to $x
        extract($row);

        $comanda_item = array(
            "id_det_comanda" => $id_det_comanda,
            "id_comanda" => $id_comanda,
            "id_tavolo" => $id_tavolo,
            "id_menu" => $id_menu,
            "nome" => $nome,
            "prezzo" => $prezzo,
            "stato" => $stato
        );
        array_push($comanda_arr['records'], $comanda_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show data in json format
    echo json_encode($comanda_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Non è stato trovato alcun risultato, riprova più tardi."));
}
