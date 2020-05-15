<?php

namespace App\Models;

use App\Core\App;

class Quizzes {
    protected static $table = 'quizzes';

    public static function newQuiz($quiz) {
        if (!preg_match("^[a-zA-z0-9]: [a-z)]$", $quiz['QuestionsAns'])) {
            throw new \Exception("The question and the answer aren't in a correct format: question: ans)");
        }
        if ($quiz['CourseID']==null) {
            throw new \Exception("The quiz should belong to a course");
        }
        App::get('database')->insert(static::$table, $quiz);
    }

    public static function getQuiz($quiz) {
        $columns = ['QuizID','CourseID', 'QuestionsAns'];
        return App::get('database')->selectOne(static::$table, $quiz, $columns);
    }
    public static function updateQuiz($quiz) {
        App::get('database')->update(static::$table, $quiz, ['QuizID'=> $quiz['QuizID']]);
    }
    // getAllQuizzes

    // deleteQuiz
    // getQuizProgress
    public static function getQuizProgress($quiz, $user) {
        $columns = ['Completed'];
        return App::get('database')->selectOne('userdoquiz', ['QuizID'=>$quiz['QuizID'], 'UserID'=>$user['UserID']], $columns);
    }
    public static function updateQuizProgress($quiz, $user, $prog) {
        $columns = ['Completed'];
        App::get('database')->update('userdoquiz', $prog, ['QuizID'=>$quiz['QuizID'], 'UserID'=>$user['UserID']]);
    }
    public static function getQuizzesTakenBy($user) {
        $columns = ['QuizID'];
        return App::get('database')->selectOne('userdoquiz', ['UserID'=>$user['UserID']], $columns);
    }
}
