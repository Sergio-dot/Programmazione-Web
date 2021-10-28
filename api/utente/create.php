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

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set utente property values
$utente->ruolo = $data->ruolo;
if ($utente->ruolo == "chef" || $utente->ruolo == "cameriere" || $utente->ruolo == "Chef" || $utente->ruolo == "Cameriere") {
    $utente->id_ristorante = $data->id_ristorante;
    $utente->nome = $data->nome;
    $utente->cognome = $data->cognome;
    $utente->email = $data->email;
    $utente->password = $data->password;
    $utente->data_nascita = $data->data_nascita;
} else if ($utente->ruolo == "fornitore" || $utente->ruolo == "Fornitore") {
    $utente->id_genere = $data->id_genere;
    $utente->nome = $data->nome;
    $utente->email = $data->email;
    $utente->password = $data->password;
}

$email_exists = $utente->emailExists();

// create new utente
if ($utente->ruolo == "chef" || $utente->ruolo == "cameriere" || $utente->ruolo == "Chef" || $utente->ruolo == "Cameriere") {
    if (
        !$email_exists &&
        !empty($utente->id_ristorante) &&
        !empty($utente->nome) &&
        !empty($utente->cognome) &&
        !empty($utente->email) &&
        !empty($utente->password) &&
        !empty($utente->data_nascita) &&
        $utente->create()
    ) {
        // set response code
        http_response_code(200);

        // display successful message
        echo json_encode(array("message" => "Il nuovo utente è stato creato con successo."));
    }

    // if unable to create new utente
    else {
        // set response code
        http_response_code(400);

        // display error message
        echo json_encode(array("message" => "Non è stato possibile creare il nuovo utente."));
    }
} else if ($utente->ruolo == "fornitore" || $utente->ruolo == "Fornitore") {
    if (
        !$email_exists &&
        !empty($utente->id_genere) &&
        !empty($utente->nome) &&
        !empty($utente->email) &&
        !empty($utente->password) &&
        $utente->create()
    ) {
        // set response code
        http_response_code(200);

        // display successful message
        echo json_encode(array("message" => "Il nuovo utente è stato creato con successo."));
    }

    // if unable to create new utente
    else {
        // set response code
        http_response_code(400);

        // display error message
        echo json_encode(array("message" => "Non è stato possibile creare il nuovo utente."));
    }
} else {
    // set response code
    http_response_code(503);

    // display error message
    echo json_encode(array("message" => "E' necessario specificare un ruolo per procedere alla creazione dell'account."));
}
