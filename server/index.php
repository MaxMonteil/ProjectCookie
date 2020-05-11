<?php

require 'vendor/autoload.php'; // Composer class autoloading
require 'core/bootstrap.php'; // Initialize the application

use App\Core\Router;
use App\Core\Request;

Router::load('app/routes.php')
    ->direct(Request::uri(), Request::method());
