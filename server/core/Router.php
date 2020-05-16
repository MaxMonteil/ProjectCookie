<?php

namespace App\Core;

/**
 * Class Router
 *
 * Application router.
 */
class Router {
    protected static $baseURL = 'api/v1';

    public $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * Load a routes file.
     *
     * @param string $file Path to the routes file.
     *
     * @return Router
     */
    public static function load(string $file): self {
        $router = new self;

        require $file;

        return $router;
    }

    /**
     * Create a GET route.
     *
     * @param string $uri URI endpoint to watch.
     * @param string $controller Name and method of the route handler. Format: 'Controller@method'.
     *
     * @return void
     */
    public function get(string $uri, string $controller): void {
        $uri = $uri == '' ? $uri : '/' . $uri;
        $this->routes['GET'][static::$baseURL . $uri] = $controller;
    }

    /**
     * Create a POST route.
     *
     * @param string $uri URI endpoint to watch.
     * @param string $controller Name and method of the route handler. Format: 'Controller@method'.
     *
     * @return void
     */
    public function post(string $uri, string $controller): void {
        $uri = $uri == '' ? $uri : '/' . $uri;
        $this->routes['POST'][static::$baseURL . $uri] = $controller;
    }


    /**
     * Handle HTTP requests to app routes.
     *
     * @param string $uri URI endpoint serve.
     * @param string $method HTTP method of the request.
     *
     * @return bool
     */
    public function direct(string $uri, string $method): void {
        if (!array_key_exists($uri, $this->routes[$method])) {
            http_response_code(404);
            echo json_encode([ 'message' => '404: Route not found.' ]);
            return;
        }

        $this->callAction(...explode('@', $this->routes[$method][$uri]));
    }

    /**
     * Call the action associated with a route's controller and request method.
     *
     * @param string $controller Name of the route Controller.
     * @param string $action Controller method to call.
     *
     * @return bool
     */
    protected function callAction(string $controller, string $action): void {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        header('Content-Type: application/json');
        $controller->$action();
    }
}
