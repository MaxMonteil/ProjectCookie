<?php

$router->post('register', 'UsersController@register');
$router->post('login', 'UsersController@login');
$router->post('changepassword', 'UsersController@changePassword');
$router->post('logout', 'UsersController@logout');
$router->post('verify', 'UsersController@verify');
$router->post('changepasswordrecovery', 'UsersController@resetPassword');
$router->post('sendpasswordrecovery', 'UsersController@forgotPasswordEmail');