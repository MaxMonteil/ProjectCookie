<?php
include_once './config/database.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$secret_key = "YOUR_SECRET_KEY";
$jwt = null;
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$authheaders = apache_request_headers();

$arr = explode(" ", $authheaders['authorization']);

$jwt = $arr[1];
echo "first: ";
echo $jwt;
if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        $secret_key = "YOUR_SECRET_KEY";
        $issuer_claim = "THE_ISSUER"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 600; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email
        ));

        $jwt = JWT::encode($token, $secret_key);
        $cookie_name = "jwt";
        $cookie_value = $jwt;

        setcookie($cookie_name, $cookie_value, time() + (600), "/"); //change time according to jwt

        http_response_code(200);

        echo json_encode(array(
            "message" => "Access granted.",
            "token" => $jwt
        ));
    } catch (Exception $e) {
        setcookie('jwt', null, time() - 3600, "/");
        setcookie('email', null, time() - 3600, "/");

        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} else {
    setcookie('jwt', null, time() - 3600, "/");
    setcookie('email', null, time() - 3600, "/");

    http_response_code(401);

    echo json_encode(array(
        "message" => "Access denied.",
        "error" => "No Access"
    ));
}
