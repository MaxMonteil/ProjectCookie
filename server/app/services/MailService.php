<?php

namespace App\Services\Notifications;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    protected static $phpMailer;

    public static function setup($config) {
        static::$phpMailer = new PHPMailer(true);
        static::$phpMailer->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                ]
            ];

        //Server settings
        static::$phpMailer->SMTPDebug = 2;
        static::$phpMailer->isSMTP();
        static::$phpMailer->Host = "smtp.gmail.com";
        static::$phpMailer->SMTPAuth = true;
        static::$phpMailer->Username = $config['username'];
        static::$phpMailer->Password = $config['password'];
        static::$phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        static::$phpMailer->Port = 587;
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
        static::$phpMailer->setFrom(static::$phpMailer->Username, 'ProjectCookie Verification');
        static::$phpMailer->addAddress($email);

        // Content
        static::$phpMailer->isHTML(false);
        static::$phpMailer->Subject = 'Signup | Verification';
        static::$phpMailer->Body = "
            Thanks for signing up!
            Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

            ------------------------
            Email: {$email}
            ------------------------

            Please click this link to activate your account:
            http://localhost:8888/Cmps278-Project/ProjectCookie/server/test-authentication/api/verify.php?email={$email}&hash={$token}";

        try {
            static::$phpMailer->send();
        } catch (Exception $e) {
            throw new \Exception($e->errorMessage());
        }
    }
}
