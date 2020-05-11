<?php

class Quizzes {
    protected static $table = 'quizzes';
    $questionsAns;
    public static function newQuiz($quiz) {
        PDOException $e;
        if(!preg_match(^[a-zA-z0-9]: [a-z)]$,$questionsAns)){
            die(var_dump($e->"The question and the answer aren't in a correct format: question: ans)"));
        }
        if($courseID==NULL){
            die(var_dump($e->"The quiz should belong to a course"));
        }
        App::get('database')->insert(static::$table, $quiz);
    }

    public static function getQuiz($quiz) {
        $columns = [ 'QuizID','CourseID', 'QuestionsAns'];
        return App::get('database')->selectOne(static::$table, $quiz, $columns);
    }
    public static function updateQuiz($quiz, $quizID){
        return App::get('database')->update(static::$table, $quiz, $quizID);
    }
}

