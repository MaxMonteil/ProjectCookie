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

    // getClassProgress
    public static function getClass($class) {
        $columns = ['ClassID', 'ClassName', 'VideoPath', 'Description', 'ModuleName', 'CourseID'];
        return App::get('database')->selectOne(static::$table, $class, $columns);
    }
    // getClassProgress
    public static function getAllClass($paramName, $paramValue) {
        $columns = ['ClassID', 'ClassName', 'VideoPath', 'Description', 'ModuleName', 'CourseID'];
        return App::get('database')->selectByAttrValues(static::$table, $paramName, $paramValue, $columns);
    }
    // getClassProgress
    public static function getClassProg($class, $user){
        $columns = ['ClassProgress', 'Completed'];
        return App::get('database')->selectOne('userattendclass',  ['ClassID'=>$class['ClassID'], 'UserID'=> $user['UserID']] , $columns);
    }
    public static function updateClassProg($class, $user, $prog){ // or just combine the new progress in $class as in models/courses.php
        App::get('database')->update('userattendclass', $prog, ['ClassID'=>$class['ClassID'], 'UserID'=> $user['UserID']]); // where $prog is associative array
    }
    public static function getClassesAttendedBy($user){
        $columns = ['ClassID'];
        return App::get('database')->selectOne('userattendclass',  ['UserID'=> $user['UserID']] , $columns);
    }    
}