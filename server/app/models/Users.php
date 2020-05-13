<?php

namespace App\Models;

use App\Core\App;

class Users {
    protected static $table = 'Users';

    /**
     * Insert a new user into the database
     *
     * @param array $user User data to insert
     *
     * @return void
     */
    public static function newUser($user): void {
        // field validation
        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*])[0-9A-Za-z!@#$%^&*]{8,}$/", $user['Password'])) {
            throw new \Exception("This password is weak, please enter another one");
        }
        $user['Password'] = password_hash($user['Password'], PASSWORD_BCRYPT);
        if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]{2,})+(\.[a-zA-Z0-9-]{2,})*(\.[a-zA-Z]{2,})$/", $user['Email'])) {
            throw new \Exception("Invalid email, please enter another one");
        }
        try {
            App::get('database')->insert(static::$table, $user);
        } catch (\Exception $e) {
            throw new \Exception("Email already exists");
        }
    }
    /**
     * Get user from the database
     *
     * @param array $user conditions to get user
     *
     * @return array
     */
    public static function getUser($user) {
        $columns = ['UserID', 'Name', 'Email', 'Password', 'Verified', 'EmailHash'];
        return App::get('database')->selectOne(static::$table, $user, $columns);
    }
    
    /**
     * Update password of certain user in the database
     *
     * @param array $user Email and new password to update it
     *
     * @return void
     */
    public static function updatePass($user) {
        $password_hash = password_hash($user['Password'], PASSWORD_BCRYPT);
        App::get('database')->update(static::$table, ['Password'=> $password_hash], ['Email'=> $user['Email']]); // $user = [Email => "ksjd@gmail.com", password => "something"]
    }
    /**
     * verify user and update database
     *
     * @param array $user User email
     *
     * @return void
     */
    public static function verifyUser($user) {
        App::get('database')->update(static::$table, ['EmailHash'=> null, 'Verified'=> 1], ['Email'=> $user['Email']]);
    }
}
