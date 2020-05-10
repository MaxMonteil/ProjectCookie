<?php
include_once './config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$firstName = '';
$lastName = '';
$email = '';
$password = '';
$conn = null;

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

    if (!preg_match("/^\s*([a-zA-Z]{2,})+\s*$/", $firstName)) {
        print "Invalid First Name submitted.";
        return;
    }
    if (!preg_match("/^\s*([a-zA-Z]{2,})+\s*$/", $lastName)) {
        print "Invalid Last Name submitted.";
        return;
    }
    if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]{2,})+(\.[a-zA-Z0-9-]{2,})*(\.[a-zA-Z]{2,})$/", $email)) {
        print "Invalid email submitted.";
        return;
    }
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*])[0-9A-Za-z!@#$%^&*]{8,}$/", $password)) {
        print "Invalid password submitted (Should contain at least one small letter, one capital letter, one number, and one of the following (!@#$%^&*) symbols).";
        return;
    }
    if ($confirmpassword != $password) {
        print "Password do not match.";
        return;
    }

$table_name = 'Users';

$query = "INSERT INTO " . $table_name . "
                SET first_name = :firstname,
                    last_name = :lastname,
                    email = :email,
                    password = :password";

$stmt = $conn->prepare($query);

$stmt->bindParam(':firstname', $firstName);
$stmt->bindParam(':lastname', $lastName);
$stmt->bindParam(':email', $email);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt->bindParam(':password', $password_hash);


if($stmt->execute()){

    //http_response_code(200);
    echo json_encode(array("message" => "User was successfully registered."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "Unable to register the user."));
}
?>