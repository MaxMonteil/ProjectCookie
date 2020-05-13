<?php

namespace App\Core;

/**
 * Class Request
 *
 * Parse the request object for needed values.
 */
class Request {
    /**
     * Get the request URI.
     *
     * @return string The parsed request URI.
     */
    public static function uri(): string {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
        );
    }

    /**
     * Get the request method.
     *
     * @return string The request method.
     */
    public static function method(): string {
        return $_SERVER['REQUEST_METHOD'];
    }
}
