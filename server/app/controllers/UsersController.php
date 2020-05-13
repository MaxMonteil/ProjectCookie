<?php

namespace App\Controllers;

use App\Models\Users;
use App\Services\Notifications\MailService;
use \Firebase\JWT\JWT;

/**
 * Class UsersController
 *
 * Controller for user related routes
 */
class UsersController {
    /**
     * Register User
     *
     * @return void
     */
    public function register(): void {
        // TODO properly generate the token
        $token = md5(rand(0, 1000));
        $data = json_decode(file_get_contents('php://input'), true);

        $email = htmlspecialchars($data['email']);
        $password = $data['password'];
        $confirmpassword = $data['confirmpassword'];

        if ($password != $confirmpassword) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Passwords do not match' ]);
            return;
        }
        
        try {
            Users::newUser([
            'Email' => $email,
            'Password' => $password,
            'EmailHash' => $token,
            ]);
        } catch(\Exception $e) {
            http_response_code(400);
            echo json_encode([ 'message' => $e->getMessage() ]);
            return;
        }

        try {
            MailService::sendVerification($email, $token);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Failed to send email verification' ]);
            return;
        }

        http_response_code(200);
        echo json_encode([ 'message' => 'user created successfully' ]);
    }

    /**
     * Log user into their account
     *
     * @param array $user user login data
     * @return void
     */
    public function login(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        $email = htmlspecialchars($data['email']);
        $password = $data['password'];

        $user = Users::getUser([
            'Email' => $email,
        ]);
        
        if (!$user) {
            http_response_code(400);
            echo json_encode([ 'message' => 'no user with this email address found',
            "email" => $email ]);
            return;
        }

        if (!password_verify(htmlspecialchars($password), $user['Password'])) {
            http_response_code(400);
            echo json_encode([ 'message' => 'incorrect password',
            "email" => $email ]);
            return;
        }

        if (!$user['Verified']) {
            http_response_code(400);
            echo json_encode([
                "message" => "account not verified",
                "email" => $user['Email'],
            ]);
            return;
        }

        $time = time();
        $expire_claim = $time + 600;

        $token = [
            "iss" => 'The_ISSUER',
            "aud" => 'THE_AUDIENCE',
            "iat" => $time,
            "nbf" => $time + 10,
            "exp" => $expire_claim,
            "data" => $user,
        ];

        $jwt = JWT::encode($token, 'YOUR_SECRET_KEY');

        //setcookie('jwt', $jwt, time() + (600), "/");
        //setcookie('email', $user['email'], time() + (600), "/");
        http_response_code(200);
        echo json_encode([
            "jwt" => $jwt,
            "email" => $user['Email'],
        ]);
    }

    /**
     * Change User Password
     *
     * @return void
     */
    public function changePassword(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        $email = htmlspecialchars($data['email']);
        $password = $data['password'];
        $confirmnewpassword = $data['confirmnewpassword'];
        $oldpassword = $data['oldpassword'];

        $user = Users::getUser([
            'Email' => $email,
        ]);

        if (!$user) {
            http_response_code(404);
            echo json_encode([ 'message' => 'no user with this email address found' ]);
            return;
        } else if ($password != $confirmnewpassword) {
            http_response_code(406);
            echo json_encode([ 'message' => 'Passwords do not match' ]);
            return;
        } else if (!password_verify($oldpassword, $user['Password'])) {
            http_response_code(406);
            echo json_encode([ 'message' => 'Incorrect original password' ]);
            return;
        }

        try {
            Users::updatePass([
            'Email' => $email,
            'Password' => $password,
            ]);

            http_response_code(201);
            echo json_encode([ 'message' => 'user password updated successfully' ]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([ 'message' => $e->getMessage() ]);
        }

    }

    /**
     * Logout User
     *
     * @return void
     */
    public function logout(): void {
        try {
            setcookie('jwt', null, time() - 3600, "/");
            setcookie('email', null, time() - 3600, "/");

            session_destroy();
        
            http_response_code(201);
            echo json_encode([ 'message' => 'user logged out successfully' ]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([ 'message' => $e->getMessage() ]);
        }

    }

    /**
     * Verify User Account
     *
     * @param array $user user login data
     * @return void
     */
    public function verify(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        $token = $data['token'];
        $email = htmlspecialchars($data['email']);
        $user = Users::getUser([
            'Email' => $email,
        ]);

        if (!$user) {
            http_response_code(404);
            echo json_encode([ 'message' => 'no user with this email address found' ]);
            return;
        }
        if (htmlspecialchars($token) != $user['EmailHash']) {
            http_response_code(401);
            echo json_encode([ 'message' => 'invalid token' ]);
            return;
        }
        
        try {
            Users::verifyUser([
            'Email' => $email,
            ]);
            
            http_response_code(200);
            echo json_encode([
                "message" => "account has been verified",
            ]);
            return;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([ 'message' => $e->getMessage() ]);
        }
    }

    /**
     * Reset User Forgotten Password
     *
     * @param array $user user login data
     * @return void
     */
    public function resetPassword(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        $token = $data['validator'];
        $password = $data['password'];
        $confirmpassword = $data['confirmpassword'];

        if ($password != $confirmpassword) {
            http_response_code(401);
            echo json_encode([ 'message' => 'passwords do not match' ]);
            return;
        }

        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $decryption_iv = '1234567891011121';

        // Store the encryption key
        $decryption_key = "000102030405060708090a0b0c0d0e0f";

        $decryption = openssl_decrypt(
            $token,
            $ciphering,
            $decryption_key,
            $options,
            $decryption_iv
        );

        $ar = explode("%;;;%", $decryption);

        $email = $ar[0];
        $expiry = $ar[1];

        $user = Users::getUser([
            'Email' => htmlspecialchars($email),
        ]);

        if (!$user) {
            http_response_code(404);
            echo json_encode([ 'message' => 'no user with this email address found' ]);
            return;
        }

        if (intval($expiry) < time()) {
            http_response_code(401);
            echo json_encode([ 'message' => 'expired token' ]);
            return;
        }

        try {
            Users::updatePass([
            'Email' => $email,
            'Password' => $password,
            ]);

            http_response_code(201);
            echo json_encode([ 'message' => 'user password updated successfully' ]);
            return;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([ 'message' => $e->getMessage() ]);
        }
    }

    /**
     * Forgot Password Email
     *
     * @return void
     */
    public function forgotPasswordEmail(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        $email = htmlspecialchars($data['email']);
        $user = Users::getUser([
            'Email' => $email,
        ]);

        if (!$user) {
            http_response_code(404);
            echo json_encode([ 'message' => 'no user with this email address found' ]);
            return;
        }

        $expires = new \DateTime('NOW');
        $expires->add(new \DateInterval('PT02H')); // 2 hours
        $message = $email."%;;;%".$expires->format('U');

        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';

        // Store the encryption key
        $encryption_key = "000102030405060708090a0b0c0d0e0f";

        // Use openssl_encrypt() function to encrypt the data
        $validator = openssl_encrypt(
            $message,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );

        try {
            MailService::sendRecovery($email, $validator);
            http_response_code(201);
            echo json_encode([ 'message' => 'password recovery sent to email' ]);
            return;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([ 'message' => $e->getMessage() ]);
            return;
        }

    }
}