<?php

class Class {
    protected static $table = 'classes';
    public static function newClass($class) {
        PDOException $e;
        if (is_null($class['ClassName'])
            {die(var_dump($e->"please provide the class's name"));
        } 
        if (is_null($class['VideoPath'])
            {die(var_dump($e->"please provide the course's subject"));
        }
        if (is_null($class['Description']){
            die(var_dump($e->"please provide the class's description"));
        }
        if (is_null($class['ModuleName']){
            die(var_dump($e->"please provide module name for this class"));
        } 
        if (is_null($course['CourseID']){
            die(var_dump($e->"please provide where you're going to add new class (to which course ID)"));
        }
        App::get('database')->insert(static::$table, $class);
    }

    public static function getClass($class) {
        $columns = ['ClassID', 'ClassName', 'VideoPath', 'Description', 'ModuleName', 'CourseID'];
        return App::get('database')->selectOne(static::$table, $class, $columns);
    }
    // getClassProgress
}