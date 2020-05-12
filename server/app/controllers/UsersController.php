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

        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $confirmpassword = $data['confirmpassword'];

        if ($password != $confirmpassword) {
            http_response_code(406);
            echo json_encode([ 'message' => 'Passwords do not match' ]);
            return;
        }
        
        try {
            Users::newUser([
            'Name' => $name,
            'Email' => $email,
            'Password' => $password,
            'EmailHash' => $token,
            ]);
        } catch(\Exception $e) {
            http_response_code(401);
            echo json_encode([ 'message' => $e->getMessage() ]);
            return;
        }

        try {
            MailService::sendVerification($email, $token);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([ 'message' => $e->getMessage() ]);
            return;
        }

        http_response_code(201);
        echo json_encode([ 'message' => 'user created successfully' ]);
    }

    /**
     * Log user into their account
     *
     * @param array $user user login data
     * @return void
     */
    public function login(): void {
        $user = Users::getUser([
            'email' => htmlspecialchars($_POST["email"]),
        ]);

        if (!$user) {
            http_response_code(404);
            echo json_encode([ 'message' => 'no user with this email address found' ]);
            return;
        }

        if (!password_verify(htmlspecialchars($_POST["password"]), $user['Password'])) {
            http_response_code(401);
            echo json_encode([ 'message' => 'incorrect password' ]);
            return;
        }

        http_response_code(200);
        if (!$user['verified']) {
            // setcookie("verification", false, time() + 600, "/");
            http_response_code(401);
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
            "message" => "Successful login.",
            "jwt" => $jwt,
            "email" => $user['Email'],
            "expireAt" => $expire_claim,
        ]);
    }

    /**
     * Change User Password
     *
     * @return void
     */
    public function changePassword(): void {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['newpassword'];
        $confirmnewpassword = $_POST['confirmnewpassword'];
        $oldpassword = $_POST['oldpassword'];

        $user = Users::getUser([
            'email' => $email,
        ]);

        if (!$user) {
            http_response_code(404);
            echo json_encode([ 'message' => 'no user with this email address found' ]);
            return;
        } else if ($password != $confirmnewpassword) {
            http_response_code(406);
            echo json_encode([ 'message' => 'Passwords do not match' ]);
            return;
        } else if ($oldpassword != $user['Password']) {
            http_response_code(406);
            echo json_encode([ 'message' => 'Incorrect original password' ]);
            return;
        }

        try {
            Users::updatePass([
            'email' => $_POST['email'],
            'newPassword' => $password,
            ]);

            http_response_code(201);
            echo json_encode([ 'message' => 'user created successfully' ]);
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
        $token = $_POST['token'];
        $email = htmlspecialchars($_POST["email"]);
        $user = Users::getUser([
            'email' => $email,
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
            'email' => $email,
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
        $token = $_POST['validator'];
        $password = $_POST['newpass'];
        $confirmpassword = $_POST['confirmnewpass'];

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
            'email' => htmlspecialchars($email),
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
            'email' => $email,
            'newPassword' => $password,
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
        $email = htmlspecialchars($_POST['email']);
        $user = Users::getUser([
            'email' => $email,
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