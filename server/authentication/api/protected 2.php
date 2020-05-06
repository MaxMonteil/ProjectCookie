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

if($jwt){
    try {
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        // Access is granted. Add code of the operation here 
        http_response_code(200);
        
        echo json_encode(array(
            "message" => "Access granted.",
            "token" => $jwt
        ));

    }catch (Exception $e){

    http_response_code(401);
    
    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage()
    ));
}

} else {
    http_response_code(401);
    
    echo json_encode(array(
        "message" => "Access denied.",
        "error" => "No Access"
    ));
}
?>