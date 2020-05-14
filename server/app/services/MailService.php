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
        static::$phpMailer->SMTPDebug = 0;
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
            {$_ENV['CLIENT_URL']}/auth/verify?email={$email}&hash={$token}";

        try {
            static::$phpMailer->send();
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
        static::$phpMailer->setFrom(static::$phpMailer->Username, 'ProjectCookie Password Recovery');
        static::$phpMailer->addAddress($email);

        // Content
        static::$phpMailer->isHTML(false);
        static::$phpMailer->Subject = 'Password Recovery | ProjectCookie';
        static::$phpMailer->Body = "
        Password Recovery Email!
        If you did not request to change your password, please ignore this email.

        ------------------------
        Email: {$email}
        ------------------------

        Please click this link to change your account's password:
        {$_ENV['CLIENT_URL']}/auth/password-reset?validator={$token}";

        try {
            static::$phpMailer->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
