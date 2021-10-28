<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// required to encode json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/utente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate utente object
$utente = new Utente($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt = isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if ($jwt) {

    // if decode succeed, show utente details
    try {

        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        // set utente property values
        $utente->ruolo = $data->ruolo;
        if ($utente->ruolo == "chef" || $utente->ruolo == "cameriere") {
            $utente->nome = $data->nome;
            $utente->cognome = $data->cognome;
            $utente->email = $data->email;
            $utente->password = $data->password;
            $utente->data_nascita = $data->data_nascita;
            if ($utente->ruolo == "chef") {
                $utente->id = $decoded->data->id_chef;
            } else if ($utente->ruolo == "cameriere") {
                $utente->id = $decoded->data->id_cameriere;
            }
        } else if ($utente->ruolo == "fornitore") {
            $utente->id_genere = $data->id_genere;
            $utente->nome = $data->nome;
            $utente->email = $data->email;
            $utente->password = $data->password;
            $utente->id = $decoded->data->id_fornitore;
        }

        // update the utente record
        if ($utente->update()) {
            // we have to regenerate jwt because utente details might be different
            if ($utente->ruolo == "chef") {
                $token = array(
                    "iat" => $issued_at,
                    "exp" => $expiration_time,
                    "iss" => $issuer,
                    "data" => array(
                        "id_chef" => $utente->id,
                        "nome" => $utente->nome,
                        "cognome" => $utente->cognome,
                        "email" => $utente->email,
                        "data_nascita" => $utente->data_nascita
                    )
                );
            } else if ($utente->ruolo == "cameriere") {
                $token = array(
                    "iat" => $issued_at,
                    "exp" => $expiration_time,
                    "iss" => $issuer,
                    "data" => array(
                        "id_cameriere" => $utente->id,
                        "nome" => $utente->nome,
                        "cognome" => $utente->cognome,
                        "email" => $utente->email,
                        "data_nascita" => $utente->data_nascita
                    )
                );
            } else if ($utente->ruolo == "fornitore") {
                $token = array(
                    "iat" => $issued_at,
                    "exp" => $expiration_time,
                    "iss" => $issuer,
                    "data" => array(
                        "id_fornitore" => $utente->id,
                        "id_genere" => $utente->id_genere,
                        "nome" => $utente->nome,
                        "email" => $utente->email
                    )
                );
            }
            $jwt = JWT::encode($token, $key);

            // set response code
            http_response_code(200);

            // response in json format
            echo json_encode(
                array(
                    "message" => "Le informazioni dell'utente sono state aggiornate.",
                    "jwt" => $jwt
                )
            );
        }


        // message if unable to update utente
        else {
            // set response code
            http_response_code(401);

            // show error message
            echo json_encode(array("message" => "Non è stato possibile aggiornare le informazioni, riprova."));
        }
    }

    // if decode fails, it means jwt is invalid
    catch (Exception $e) {

        // set response code
        http_response_code(401);

        // show error message
        echo json_encode(array(
            "message" => "Accesso negato.",
            "error" => $e->getMessage()
        ));
    }
}

// show error message if jwt is empty
else {

    // set response code
    http_response_code(401);

    // tell the utente access denied
    echo json_encode(array("message" => "Accesso negato."));
}
