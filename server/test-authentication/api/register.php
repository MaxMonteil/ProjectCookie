<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";
include_once './config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mail = new PHPMailer(true);

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
$hash = md5(rand(0, 1000));

$query = "INSERT INTO " . $table_name . "
                SET first_name = :firstname,
                    last_name = :lastname,
                    email = :email,
                    password = :password,
                    hash = :hash";

$stmt = $conn->prepare($query);

$stmt->bindParam(':firstname', $firstName);
$stmt->bindParam(':lastname', $lastName);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':hash', $hash);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt->bindParam(':password', $password_hash);


if ($stmt->execute()) {
    try {
        $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );
        //Server settings
            $mail->SMTPDebug = 2;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = "smtp.gmail.com";                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'projectcookievalidation@gmail.com';                     // SMTP username
            $mail->Password   = 'ProjectCookie1@';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
        $mail->setFrom('projectcookievalidation@gmail.com', 'ProjectCookie Verification');
        //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mail->addAddress($email);               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
        // Content
            $mail->isHTML(false);                                  // Set email format to HTML
            $mail->Subject = 'Signup | Verification';
        $mail->Body    = '
 
            Thanks for signing up!
            Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
             
            ------------------------
            Email: '.$email.'
            Password: '.$password.'
            ------------------------
             
            Please click this link to activate your account:
            http://localhost:8888/Cmps278-Project/ProjectCookie/server/test-authentication/api/verify.php?email='.$email.'&hash='.$hash.'
             
            ';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
        $mail->send();
        echo 'Message has been sent';
        setcookie("verification", "0", time() + (600), "/");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    //http_response_code(200);
    echo json_encode(array("message" => "User was successfully registered."));
} else {
    //http_response_code(400);

    echo json_encode(array("message" => "Unable to register the user."));
}
