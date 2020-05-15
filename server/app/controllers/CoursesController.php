<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\Users;
use App\Models\Lesson;

/**
 * Class CoursesController
 *
 * Controller for courses related routes
 */
class CoursesController {
     /**
     * Get All Courses
     *
     * @return void
     */
    public function getAllCourses(): void {
        $courses = Course::getAllCourses();

        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No user with this email address found' ]);
            return;
        }

        $allCourses = [];

        
        for ($i=0; $i < sizeof($courses); $i++) { 
            if($courses[$i]['isDraft'] == 0) {
                continue;
            }
            $temp = [
                "id" => $courses[$i]['CourseID'],
                "name" => $courses[$i]['CourseName'],
                "startDate" => $courses[$i]['StartDate'],
                "studentCount" => intval($courses[$i]['NumOfViewers']),
                "description" => $courses[$i]['Description']
            ];
            array_push($allCourses, $temp);
        }

        $allSubjects = Course::getAllParamArg('isDraft', 1, 'Subject');
        $allLanguages = Course::getAllParamArg('isDraft', 1, 'Language');

        $allSubjectsSeperated = [];
        $allLanguagesSeperated = [];

        for ($i=0; $i < sizeof($allSubjects); $i++) { 
            array_push($allSubjectsSeperated, $allSubjects[$i]['Subject']);
        }
        for ($i=0; $i < sizeof($allLanguages); $i++) { 
            array_push($allLanguagesSeperated, $allLanguages[$i]['Language']);
        }

        $arr = json_encode([ 
            'courses' => $allCourses,
            'searchOptions' => [
                'subject' => $allSubjectsSeperated,
                'language' => $allLanguagesSeperated
                ]
            ]);

        http_response_code(200);
        echo $arr;
    }

     /**
     * Get a Course
     *
     * @return void
     */
    public function getCourse(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        $courses = Course::getCourse([
            'CourseID' => $data['courseId'],
        ]);

        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No courses found' ]);
            return;
        }
        $arr = json_encode([ 
            'id' => $courses['CourseID'],
            'name' => $courses['CourseName'],
            'teacher' => $courses['Teacher'],
            'startDate' => $courses['StartDate'],
            'studentCount' => $courses['NumOfViewers'],
            'description' => $courses['Description'],
            'price' => $courses['Price'],
            'syllabus' => $courses['SyllabusName']
        ]);

        http_response_code(200);
        echo $arr;
    }

     /**
     * Get a Course by Subject
     *
     * @return void
     */
    public function getCourseBySubject(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        $allCourses = [];

        for ($i=0; $i < sizeof($data['subjects']); $i++) { 
            $courses = Course::getCourseByAttr(
                'Subject',
                [$data['subjects'][$i]]
            );

            $temp = [];

            for ($i2=0; $i2 < sizeof($courses); $i2++) { 
                if($courses[$i2]['isDraft'] == 0) {
                    continue;
                }
                $temp2 = [
                    "id" => $courses[$i2]['CourseID'],
                    "name" => $courses[$i2]['CourseName'],
                    "startDate" => $courses[$i2]['StartDate'],
                    "studentCount" => intval($courses[$i2]['NumOfViewers']),
                    "description" => $courses[$i2]['Description']
                ];
                array_push($temp, $temp2);
            }
            array_push($allCourses, [$data['subjects'][$i] => $temp]);
        }

        if(sizeof($allCourses) == 0) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No courses found' ]);
            return;
        }

        $arr = json_encode($allCourses);
        $arr = trim($arr, '[]');
        http_response_code(200);
        echo $arr;
    }

    /**
     * Get All Subjects
     *
     * @return void
     */
    public function getAllSubjects(): void {
        $courses = Course::getAllParamArg('isDraft', 1, 'Subject');
        
        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No subjects found' ]);
            return;
        }

        $allSubjects = [];

        for ($i=0; $i < sizeof($courses); $i++) { 
            array_push($allSubjects, $courses[$i]['Subject']);
        }

        http_response_code(200);
        echo json_encode([ 'subjects' => $allSubjects ]);
    }
    
    /**
     * Get All Enrolled
     *
     * @return void
     */
    public function getAllEnrolled(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);

        $userId = Users::getUser([
            'Email' => $email
        ]);

        $coursesId = Course::getCoursesTakenBy([
            'UserID' => $userId['UserID']
        ]);
        
        if (!$coursesId) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No enrolled courses' ]);
            return;
        }

        $tempId = [];

        for ($i=0; $i < sizeof($coursesId); $i++) { 
            array_push($tempId, $coursesId[$i]['CourseID']);
        }

        $courses = [];

        for ($i=0; $i < sizeof($coursesId); $i++) { 
            $getName = Course::getCourseByAttr(
                'CourseID',
                [$coursesId[$i]['CourseID']]
            );
            $temp = [
                'id' => $tempId[$i],
                'name' => $getName[0]['CourseName'],
                'progress' => intval($coursesId[$i]['CourseProgress'])
            ];
            array_push($courses, $temp);
        }

        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No class found with this id' ]);
            return;
        }

        http_response_code(200);
        echo json_encode([ 'courses' => $courses ]);
    }

    /**
     * Get Limited Enrolled
     *
     * @return void
     */
    public function getLimitedEnrolled(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);
        $limit = intval($data['limit']);

        $userId = Users::getUser([
            'Email' => $email
        ]);

        $coursesId = Course::getCoursesTakenBy([
            'UserID' => $userId['UserID']
        ]);
        
        if (!$coursesId) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No enrolled courses' ]);
            return;
        }

        $tempId = [];

        for ($i=0; $i < sizeof($coursesId); $i++) { 
            array_push($tempId, $coursesId[$i]['CourseID']);
        }

        $courses = [];

        for ($i=0; $i < sizeof($coursesId); $i++) { 
            if ($i+1 > $limit) {
                break;
            }
            $getName = Course::getCourseByAttr(
                'CourseID',
                [$coursesId[$i]['CourseID']]
            );
            $temp = [
                'id' => $tempId[$i],
                'name' => $getName[0]['CourseName'],
                'progress' => intval($coursesId[$i]['CourseProgress'])
            ];
            array_push($courses, $temp);
        }

        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No class found with this id' ]);
            return;
        }

        http_response_code(200);
        echo json_encode([ 'courses' => $courses ]);
    }

    /**
     * Get All Completed Courses
     *
     * @return void
     */
    public function getAllCompleted(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);

        $userId = Users::getUser([
            'Email' => $email
        ]);

        $coursesId = Course::getCoursesTakenBy([
            'UserID' => $userId['UserID']
        ]);
        
        if (!$coursesId) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No enrolled classes' ]);
            return;
        }

        $tempId = [];

        for ($i=0; $i < sizeof($coursesId); $i++) { 
            array_push($tempId, $coursesId[$i]['CourseID']);
        }

        $courses = [];

        for ($i=0; $i < sizeof($coursesId); $i++) { 
            if($coursesId[$i]['CourseProgress'] != 100) {
                continue;
            }
            $getName = Course::getCourseByAttr(
                'CourseID',
                [$coursesId[$i]['CourseID']]
            );
            $temp = [
                'id' => $tempId[$i],
                'name' => $getName[0]['CourseName'],
                'completedOn' => $coursesId[$i]['CompletionDate']
            ];
            array_push($courses, $temp);
        }

        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No class found with this id' ]);
            return;
        }

        http_response_code(200);
        echo json_encode([ 'courses' => $courses ]);
    }

    /**
     * Get All Published Courses
     *
     * @return void
     */
    public function getAllPublished(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);

        $userId = Users::getUser([
            'Email' => $email
        ]);

        if (!$userId) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No user found with this id' ]);
            return;
        }

        $userId = intval($userId['UserID']);

        $allPublished = Course::getCourseByAttr(
            'Publisher',
            [$userId]
        );
        
        if (!$allPublished) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No published courses' ]);
            return;
        }

        $courses = [];

        for ($i=0; $i < sizeof($allPublished); $i++) { 
            if($allPublished[$i]['isDraft'] == 0) {
                continue;
            }
            $temp = [
                'id' => $allPublished[$i]['CourseID'],
                'name' => $allPublished[$i]['CourseName'],
            ];
            array_push($courses, $temp);
        }

        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No published courses' ]);
            return;
        }

        http_response_code(200);
        echo json_encode([ 'courses' => $courses ]);
    }

    /**
     * Get All Drafted Courses
     *
     * @return void
     */
    public function getAllDrafts(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);

        $userId = Users::getUser([
            'Email' => $email
        ]);

        if (!$userId) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No user found with this id' ]);
            return;
        }

        $userId = intval($userId['UserID']);

        $allDrafts = Course::getCourseByAttr(
            'Publisher',
            [$userId]
        );
        
        if (!$allDrafts) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No drafted courses' ]);
            return;
        }

        $courses = [];

        for ($i=0; $i < sizeof($allDrafts); $i++) { 
            if($allDrafts[$i]['isDraft'] == 1) {
                continue;
            }
            $temp = [
                'id' => $allDrafts[$i]['CourseID'],
                'name' => $allDrafts[$i]['CourseName'],
            ];
            array_push($courses, $temp);
        }

        if (!$courses) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No drafted courses' ]);
            return;
        }

        http_response_code(200);
        echo json_encode([ 'courses' => $courses ]);
    }

    /**
     * Get A Lesson
     *
     * @return void
     */
    public function getLessons(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);
        $courseid = intval($data['courseid']);
        $lessonid = intval($data['lessonid']);

        $userId = Users::getUser([
            'Email' => $email
        ]);

        if (!$userId) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No user found with this id' ]);
            return;
        }

        $userId = intval($userId['UserID']);

        $allCoursesTaken = Course::getCoursesTakenBy([
            'UserID' => $userId
        ]);

        if (!$allCoursesTaken) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Not enrolled in any course' ]);
            return;
        }
        
        $enrolled = false;

        for ($i=0; $i < sizeof($allCoursesTaken); $i++) { 
            if($allCoursesTaken[$i]['CourseID'] == $courseid) {
                $enrolled = true;
                break;
            }
        }
        
        if (!$enrolled) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Not enrolled in this course' ]);
            return;
        }

        $getCourseInfo = Course::getCourseByAttr(
            'CourseID',
            [$courseid]
        );

        if (!$getCourseInfo) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No courses with this id' ]);
            return;
        }

        $lessons = Lesson::getClass([
            'ClassID' => $lessonid,
        ]);
        
        if(intval($lessons['CourseID']) != $courseid) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Lesson does not belong to course provided' ]);
            return;
        }

        $allLessons = Lesson::getAllClass(
            'CourseID',
            [$courseid]
        );

        $allLessonsId = [];

        for ($i=0; $i < sizeof($allLessons); $i++) { 
            array_push($allLessonsId, $allLessons[$i]['ClassID']);
        }
        sort($allLessonsId);

        $previous =  intval(array_search($lessonid, $allLessonsId, false)) - 1;
        if ($previous < $allLessons[0] ) {
            $previous = array_search($lessonid, $allLessonsId, false);
        }
        $next = intval(array_search($lessonid, $allLessonsId, false)) + 1;
        echo $next;
        if ($next >= sizeof($allLessonsId)) {
            $next = array_search($lessonid, $allLessonsId, false);
        }

        $temp = [
            "id" => $lessons['ClassID'],
            "sectionId" => $lessons['ClassID']."-".$lessons['ModuleName'],
            "courseId" => $lessons['CourseID'],
            "prevLessonId" => $allLessonsId[$previous],
            "nextLessonId" => $allLessonsId[$next],
            "name" => $lessons['ModuleName'],
            "description" => $lessons['Description'],
            "completed" => $lessons['Description'],
            "link" => $lessons['VideoPath'],
            "type" => $lessons['Description'],
            "questions" => $lessons['Description']
        ];

        http_response_code(200);
        echo json_encode([ 
            'courseName' => $getCourseInfo[0]['CourseName'],
            'lesson' => $temp 
        ]);
    }

    /**
     * Complete A Lesson
     *
     * @return void
     */
    public function completeLesson(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);
        $courseid = intval($data['courseid']);
        $lessonid = intval($data['lessonid']);

        $userId = Users::getUser([
            'Email' => $email
        ]);

        if (!$userId) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No user found with this id' ]);
            return;
        }

        $userId = intval($userId['UserID']);

        $allCoursesTaken = Course::getCoursesTakenBy([
            'UserID' => $userId
        ]);

        if (!$allCoursesTaken) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Not enrolled in any course' ]);
            return;
        }
        
        $enrolled = false;

        for ($i=0; $i < sizeof($allCoursesTaken); $i++) { 
            if($allCoursesTaken[$i]['CourseID'] == $courseid) {
                $enrolled = true;
                break;
            }
        }
        
        if (!$enrolled) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Not enrolled in this course' ]);
            return;
        }


        $getCourseInfo = Course::getCourseByAttr(
            'CourseID',
            [$courseid]
        );

        if (!$getCourseInfo) {
            http_response_code(400);
            echo json_encode([ 'message' => 'No courses with this id' ]);
            return;
        }

        $lessons = Lesson::getClass([
            'ClassID' => $lessonid,
        ]);
        
        if(intval($lessons['CourseID']) != $courseid) {
            http_response_code(400);
            echo json_encode([ 'message' => 'Lesson does not belong to course provided' ]);
            return;
        }

        try {
            Lesson::updateClassProg([
                'ClassID' => $lessonid
            ],
            [
                'UserID' => $courseid
            ], 
            [
                'ClassProgress' => 100,
                'Completed' => 1
            ]);
            http_response_code(200);
        } catch (\Exception $e) {
            echo json_encode([ 'message' => $e->getMessage() ]);
        }
    }

    /**
     * Search
     *
     * @return void
     */
    public function Search(): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $search = strtolower(trim(htmlspecialchars($data['search'])));

        $classes = Course::getAllCourses();

        $results = [];

        for ($i=0; $i < sizeof($classes); $i++) { 
            if (strpos(strtolower($classes[$i]['CourseName']), $search) !== false) {
                array_push($results, $classes[$i]);
            }
        }
        //array_unique
        $allCourses = [];


        for ($i=0; $i < sizeof($results); $i++) { 
            if($results[$i]['isDraft'] == 0) {
                continue;
            }   
            $temp = [
                "id" => $results[$i]['CourseID'],
                "name" => $results[$i]['CourseName'],
                "startDate" => $results[$i]['StartDate'],
                "studentCount" => intval($results[$i]['NumOfViewers']),
                "description" => $results[$i]['Description']
            ];
            array_push($allCourses, $temp);
        }

        http_response_code(200);
        echo json_encode([ 
            'courses' => $allCourses
        ]);
    }
}