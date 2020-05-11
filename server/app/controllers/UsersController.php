<?php

namespace App\Controllers;

use App\Models\Users;
use App\Services\Notifications\MailService;

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
    public function store(): bool {
        Users::newUser([
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ]);

        // TODO properly generate the token
        $token = md5(rand(0, 1000));
        try {
            MailService::sendVerification($_POST['email'], $token);
        } catch (\Exception $e) {
            // TODO handle this
            return $e->getMessage();
        }

        // TODO return success code 200
        return true;
    }
}
