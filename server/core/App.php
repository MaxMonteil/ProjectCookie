<?php

namespace App\Core;

/**
 * Class App
 *
 * Dependency injection container for the application.
 */
class App
{
    protected static $registry = [];

    /**
     * Bind a dependency to the Application's registry.
     *
     * @param string $key The key under which to store the dependency.
     * @param mixed $dep The dependency to be stored.
     *
     * @return void
     */
    public static function bind(string $key, $dep): void
    {
        static::$registry[$key] = $dep;
    }

    /**
     * Retrieve a dependency from the registry.
     *
     * @param string $key The key to the registry value to return.
     *
     * @return mixed The registry dependency.
     */
    public static function get(string $key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception("No {$key} is bound in the container");
        }

        return static::$registry[$key];
    }
}
