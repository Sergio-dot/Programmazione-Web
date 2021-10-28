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

// instantiate user object
$user = new Utente($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set property values
$user->ruolo = $data->ruolo;
$user->email = $data->email;
$email_exists = $user->emailExists();

// generate json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

// check if email exists and if password is correct
if ($user->ruolo == "chef" || $user->ruolo == "cameriere" || $user->ruolo == "admin") {
    if ($email_exists && password_verify($data->password, $user->password)) {
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "nome" => $user->nome,
                "cognome" => $user->cognome,
                "email" => $user->email,
                "ruolo" => $user->ruolo
            )
        );

        // get user ID in base of role 'chef' or 'cameriere'
        if ($user->ruolo == "chef") {
            $token['data']['id_chef'] = $user->id;
        } else if ($user->ruolo == "cameriere") {
            $token['data']['id_cameriere'] = $user->id;
        } else if ($user->ruolo == "admin") {
            $token['data']['id_admin'] = $user->id;
        }

        // set response code - 200 OK
        http_response_code(200);

        // generate jwt
        $jwt = JWT::encode($token, $key);

        echo json_encode(
            array(
                "message" => "Login effettuato con successo.",
                "jwt" => $jwt,
                "token" => $token
            )
        );
    }
} else if ($user->ruolo == "fornitore") {
    if ($email_exists && password_verify($data->password, $user->password)) {
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "id_genere" => $user->id_genere,
                "nome" => $user->nome,
                "email" => $user->email,
                "ruolo" => $user->ruolo
            )
        );

        // get user ID
        $token['data']['id_fornitore'] = $user->id;

        // set response code - 200 OK
        http_response_code(200);

        // generate jwt
        $jwt = JWT::encode($token, $key);

        echo json_encode(
            array(
                "message" => "Login effettuato con successo.",
                "jwt" => $jwt,
                "token" => $token
            )
        );
    }
}

// login failed
else {
    // set response code - 401 Unauthorized
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("message" => "I dati inseriti non sono corretti, riprova."));
}
