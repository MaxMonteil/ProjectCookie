<?php

namespace App\Models;

use App\Core\App;

class Users {
    protected static $table = 'users';

    /**
     * Insert a new user into the database
     *
     * @param array $user User data to insert
     *
     * @return void
     */
    public static function newUser($user): void {
        // field validation
        PDOException $e;
        if(!preg_match(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$,$user['Password'])){
            die(var_dump($e->"This password is weak, please enter another one"));
        }
        if(!preg_match(^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$, $user['Email'])){
            die(var_dump($e->"Invalid email, please enter another one"));
        }
        App::get('database')->insert(static::$table, $user);
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
    public static function updatePass($user){
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
    public static function verifyUser($user){
        App::get('database')->update(static::$table, ['EmailHash'=> null, 'Verified'=> 1], ['Email'=> $user['Email']]);
    }

}