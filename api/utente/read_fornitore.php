<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/projects/programmazione_web/api");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/utente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate product object
$utente = new Utente($db);

$stmt = $utente->read_fornitore();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // make a table array
    $utente_arr = array();
    $utente_arr['records'] = array();

    // retrieve table contents through fetch()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // e.g. this will make $row['x'] to $x
        extract($row);

        $utente_item = array(
            'id_fornitore' => $id_fornitore,
            'id_genere' => $id_genere,
            'nome_genere' => $nome_genere,
            'nome' => $nome,
            'email' => $email
        );

        array_push($utente_arr['records'], $utente_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show data in json format
    echo json_encode($utente_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Non è stato trovato alcun risultato, riprova più tardi."));
}
