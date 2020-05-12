<?php

namespace App\Models;

use App\Core\App;

class Lesson {
    protected static $table = 'classes';
    public static function newClass($class) {
        if (is_null($class['ClassName'])) {
            throw new \Exception("please provide the class's name");
        } 
        if (is_null($class['VideoPath'])) {
            throw new \Exception("please provide the course's subject");
        }
        if (is_null($class['Description'])) {
            throw new \Exception("please provide the class's description");
        }
        if (is_null($class['ModuleName'])) {
            throw new \Exception("please provide module name for this class");
        } 
        if (is_null($class['CourseID'])) {
            throw new \Exception("please provide where you're going to add new class (to which course ID)");
        }
        App::get('database')->insert(static::$table, $class);
    }

    public static function getClass($class) {
        $columns = ['ClassID', 'ClassName', 'VideoPath', 'Description', 'ModuleName', 'CourseID'];
        return App::get('database')->selectOne(static::$table, $class, $columns);
    }
    // getClassProgress
}