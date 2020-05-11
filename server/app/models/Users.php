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
        if(!preg_match(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$,$password)){
            die(var_dump($e->"This password is weak, please enter another one"));
        }
        if(!preg_match(^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$, $Email)){
            die(var_dump($e->"Invalid email, please enter another one"));
        }
        App::get('database')->insert(static::$table, $user);
    }
    public static function getUser($user) {
        $columns = ['UserID', 'Name', 'Email', 'Password', 'Verified', 'HashEmail'];
        return App::get('database')->selectOne(static::$table, $user, $columns);
    }
    public static function updatePass($user, $Email){
        return App::get('database')->update(static::$table, $user, $Email);
    }
}