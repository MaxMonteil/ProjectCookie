<?php

class User {
    protected static $table = 'users';
    $password;
    public static function newUser($user) {
        PDOException $e;
        if(!preg_match(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$,$password)){
            die(var_dump($e->"This password is weak, please enter another one"));
        }
        if(!preg_match(^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$, $Email)){
            die(var_dump($e->"Invalid email, please enter another one"));
        }
        App::get('db')->insert(static::$table, $user);
    }

    public static function getUser($user) {
        $columns = ['UserID', 'Name', 'Email', 'Password', 'Verified', 'HashEmail'];
        return App::get('db')->selectOne(static::$table, $user, $columns);
    }
    public static function updatePass($user){
        return App::get('db')->update(static::$table, $user, $Email);
    }
}