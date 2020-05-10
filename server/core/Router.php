<?php

namespace App\Core;

/**
 * Class Router
 *
 * Application router.
 */
class Router {
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
        $this->routes['GET'][$uri] = $controller;
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
        $this->routes['POST'][$uri] = $controller;
    }


    /**
     * Handle HTTP requests to app routes.
     *
     * @param string $uri URI endpoint serve.
     * @param string $method HTTP method of the request.
     *
     * @return bool
     */
    public function direct(string $uri, string $method): bool {
        if (array_key_exists($uri, $this->routes[$method])) {
            return $this->callAction(
                ...explode('@', $this->routes[$method][$uri]),
            );
        }

        throw new \Exception('No route defined for this URI.');
    }

    /**
     * Call the action associated with a route's controller and request method.
     *
     * @param string $controller Name of the route Controller.
     * @param string $action Controller method to call.
     *
     * @return bool
     */
    protected function callAction(string $controller, string $action): bool {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}
