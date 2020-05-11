<?php

class Course {
    protected static $table = 'courses';
    public static function newCourse($course) {
        PDOException $e;
        if (is_null($course['CourseName'])
            {die(var_dump($e->"please provide the course's name"));
        } 
        if (is_null($course['Subject'])
            {die(var_dump($e->"please provide the course's subject"));
        }
        if (is_null($course['Description']){
            die(var_dump($e->"please provide the course's description"));
        }
        if (is_null($course['RecommendedUsers']){
            die(var_dump($e->"please provide recommended users for the course"));
        } 
        if (is_null($course['StartDate']){
            die(var_dump($e->"please provide start date for the course"));
        }  
        if (is_null($course['EndDate']){
            die(var_dump($e->"please provide end date for the course"));
        }  
        if (is_null($course['Price']){
            die(var_dump($e->"please provide course's price"));
        }  
        if (is_null($course['Teacher']){
            die(var_dump($e->"please provide a teacher for this course"));
        }   
        if (is_null($course['Language']){
            die(var_dump($e->"please state the language used in this course"));
        }   
        if (is_null($course['SyllabusName']){
            die(var_dump($e->"please provide syllabus name for this course"));
        }   
        App::get('database')->insert(static::$table, $course);
    }

    public static function getCourse($course) {
        $columns = ['CourseID', 'CourseName', 'Subject', 'Description', 'RecommendedUsers', 'StartDate', 'EndDate', 'Price', 'NumOfViewers','Language', 'Teacher', 'SyllabusName'];
        return App::get('database')->selectOne(static::$table, $course, $columns);
    }
    public static function updateCourse($course, $courseID){
        return App::get('database')->update(static::$table, $course, ['CourseID'=>$course['CourseID']]);
    }
    // get all courses a certain user is taking (use UserJoinCourse table)
    // get courses by attribute (for example: courses given by certain teacher, or have a certain price, etc. )
}