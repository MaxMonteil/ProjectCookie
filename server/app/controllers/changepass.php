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

$oldpass = $_POST["oldpass"];
$newpass = $_POST['newpass'];
$confnewpass = $_POST['confnewpass'];

if ($confnewpass != $newpass) {
    http_response_code(200);
    echo json_encode(array(
        "message" => "Password not changed.",
        "error" => "Passwords do not match."
    ));
    return;
}

$jwt = $_COOKIE["jwt"];

if ($jwt) {
    $email = $_COOKIE["email"];
    try {
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        $table_name = 'Users';

        $query = "SELECT id, first_name, last_name, password FROM " . $table_name . " WHERE email = ? LIMIT 0,1";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        $num = $stmt->rowCount();

        http_response_code(200);

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $password2 = $row['password'];
            if (password_verify($oldpass, $password2)) {
                $query = "UPDATE " . $table_name . "
                SET password = :password WHERE email = :email";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $password_hash = password_hash($newpass, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);

                if ($stmt->execute()) {
                    echo json_encode(array("message" => "Passwored Changed."));
                } else {
                    echo json_encode(array("message" => "Unable to change password of user."));
                }
            } else {
                echo json_encode(array("message" => "Wrong Password."));
            }
        } else {
            echo json_encode(array("message" => "Email does not exist."));
        }
    } catch (Exception $e) {
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
