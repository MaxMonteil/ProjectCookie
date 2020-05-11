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

        App::get('database')->insert(static::$table, $user);
    }
}
