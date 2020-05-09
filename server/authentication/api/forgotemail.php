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

$email = '';
$conn = null;

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$email = $_POST['email'];
    if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]{2,})+(\.[a-zA-Z0-9-]{2,})*(\.[a-zA-Z]{2,})$/", $email)) {
        print "Invalid email submitted.";
        return;
    }

$table_name = 'Users';

$query = "SELECT verified FROM " . $table_name . " WHERE email = ? LIMIT 0,1";

$stmt = $conn->prepare( $query );
$stmt->bindParam(1, $email);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0){
    $token = random_bytes(32);
    $validator = bin2hex($token);
    $hash = hash('sha256', $token);
    $expires = new DateTime('NOW');
    $expires->add(new DateInterval('PT02H')); // 2 hours

    $query2 = "UPDATE " . $table_name . "
        SET `passhash`= :hash, `passhashexpire`= :expire WHERE email  = :email";
    $stmt = $conn->prepare( $query2 );
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':hash', $hash);
    $stmt->bindParam(':expire', $expires->format('U'));

    if($stmt->execute()){
        try {
            //Server settings
            $mail->SMTPDebug = 3;                      // Enable verbose debug output
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
            $mail->Subject = 'Email Recovery | ProjectCookie';
            $mail->Body    = '
 
            Password Recovery Email!
            If you did not request to change your password, please ignore this email.
             
            ------------------------
            Email: '.$email.'
            ------------------------
             
            Please click this link to change your account\'s password:
            http://localhost:8888/Cmps278-Project/ProjectCookie/server/test-authentication/api/reset.php?email='.$email.'&validator='.$validator.'
             
            ';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            $mail->send();
            echo 'Message has been sent';
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    else{
        echo 'Unable to send password recovery';
    }
}
else{
    //http_response_code(400);

    echo json_encode(array("message" => "Unable to register the user."));
}
?>