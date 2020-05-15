<?php

$router->post('register', 'UsersController@register');
$router->post('login', 'UsersController@login');
$router->post('changepassword', 'UsersController@changePassword');
$router->post('logout', 'UsersController@logout');
$router->post('verify', 'UsersController@verify');
$router->post('changepasswordrecovery', 'UsersController@resetPassword');
$router->post('sendpasswordrecovery', 'UsersController@forgotPasswordEmail');
$router->post('courses', 'CoursesController@getCourse');
$router->get('courses', 'CoursesController@getAllCourses');
$router->post('subjects', 'CoursesController@getCourseBySubject');
$router->get('subjects', 'CoursesController@getAllSubjects');
$router->post('enrolled', 'CoursesController@getLimitedEnrolled');
$router->get('enrolled', 'CoursesController@getAllEnrolled');
$router->get('completed', 'CoursesController@getAllCompleted');
$router->post('published', 'CoursesController@getAllPublished');
$router->post('drafts', 'CoursesController@getAllDrafts');
$router->post('lessons', 'CoursesController@getLessons');
$router->post('complete-lesson', 'CoursesController@completeLesson');
$router->post('search', 'CoursesController@search');