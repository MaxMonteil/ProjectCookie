<?php

namespace App\Services\Notifications;

use Exception as GlobalException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    private $phpMailer;

    public function __construct($config) {
        $this->phpMailer = new PHPMailer(true);
        $this->phpMailer->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                ]
            ];

        //Server settings
        $this->phpMailer->SMTPDebug = 0;
        $this->phpMailer->isSMTP();
        $this->phpMailer->Host = "smtp.gmail.com";
        $this->phpMailer->SMTPAuth = true;
        $this->phpMailer->Username = $config['username'];
        $this->phpMailer->Password = $config['password'];
        $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->phpMailer->Port = 587;
    }

    /**
     * Send the verifcation email to a new user with a link to activate their account
     *
     * @param string $email the user's email address
     * @param string $token a unique token to validate their identity on the site
     *
     * @return void
     */
    public static function sendVerification(string $email, $token): void {
        //Recipients
        $this->phpMailer->setFrom($this->phpMailer->Username, 'ProjectCookie Verification');
        $this->phpMailer->addAddress($email);

        // Content
        $this->phpMailer->isHTML(false);
        $this->phpMailer->Subject = 'Signup | Verification';
        $this->phpMailer->Body = "
            Thanks for signing up!
            Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

            ------------------------
            Email: {$email}
            ------------------------

            Please click this link to activate your account:
            http://localhost:8888/Cmps278-Project/ProjectCookie/server/test-authentication/api/verify.php?email={$email}&hash={$token}";

        try {
            $this->phpMailer->send();
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Send the password recovery email to a user with a link to change their password
     *
     * @param string $email the user's email address
     * @param string $token a unique token to validate their identity on the site
     *
     * @return void
     */
    public static function sendRecovery(string $email, $token): void {
        //Recipients
        $this->phpMailer->setFrom($this->phpMailer->Username, 'ProjectCookie Password Recovery');
        $this->phpMailer->addAddress($email);

        // Content
        $this->phpMailer->isHTML(false);
        $this->phpMailer->Subject = 'Password Recovery | ProjectCookie';
        $this->phpMailer->Body = "
        Password Recovery Email!
        If you did not request to change your password, please ignore this email.

        ------------------------
        Email: '.$email.'
        ------------------------

        Please click this link to change your account\'s password:
        http://localhost:8888/Cmps278-Project/ProjectCookie/server/test-authentication/api/reset.php?'.'&validator='.$token.'";

        try {
            $this->phpMailer->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
