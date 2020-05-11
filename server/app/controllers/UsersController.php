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
     * undocumented function
     *
     * @return void
     */
    public function store(): void {
        Users::newUser([
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ]);

        // TODO properly generate the token
        $token = md5(rand(0, 1000));
        try {
            MailService::sendVerification($_POST['email'], $token);
        } catch (\Exception $e) {
            echo json_encode([ 'message' => $e->getMessage() ]);
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

        if (!password_verify(htmlspecialchars($_POST["password"]), $user['password'])) {
            http_response_code(401);
            echo json_encode([ 'message' => 'incorrect password' ]);
            return;
        }

        http_response_code(200);
        if (!$user['verified']) {
            setcookie("verification", false, time() + 600, "/");
            echo json_encode([
                "message" => "account not verified",
                "email" => $user['email'],
            ]);
            return;
        }

        setcookie("verification", "", time() - 3600, "/");
        $time = time();
        $expire_claim = $time = 600;

        $token = [
            "iss" => 'The_ISSUER',
            "aud" => 'THE_AUDIENCE',
            "iat" => $time,
            "nbf" => $time + 10,
            "exp" => $expire_claim,
            "data" => $user,
        ];

        $jwt = JWT::encode($token, 'YOUR_SECRET_KEY');

        setcookie('jwt', $jwt, time() + (600), "/");
        setcookie('email', $user['email'], time() + (600), "/");

        echo json_encode([
            "message" => "Successful login.",
            "jwt" => $jwt,
            "email" => $user['email'],
            "expireAt" => $expire_claim,
        ]);
    }
}
