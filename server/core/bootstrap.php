<?php

use App\Core\App;
use App\Core\Database\QueryBuilder;
use App\Core\Database\Connection;

App::bind('config', require 'config.php');

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));

/**
 * Return a page's view from the app/views folder.
 *
 * @param string $name Name of the view
 * @param array $data \[optional\] Data to supply to the view.
 *
 * @return bool Required view file.
 */
function view(string $name, array $data = []): bool
{
    extract($data);
    return require "app/views/{$name}.view.php";
}

/**
 * Redirect the client to a given path.
 *
 * @param string $path Redirection path.
 *
 * @return void
 */
function redirect(string $path): void
{
    header("Location: /{$path}");
}
