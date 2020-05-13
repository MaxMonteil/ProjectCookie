<?php

namespace App\Core\Database;

/**
 * Class Connection
 *
 * Handle connecting to the database.
 */
class Connection {
    /**
     * Create a PDO connection to a database.
     *
     * @param array $config The database connection configuration.
     *
     * @return \PDO A connection to the database server.
     */
    public static function make($config) {
        try {
            return new \PDO(
                $config['connection'].';dbname='.$config['name'],
                $config['username'],
                $config['password'],
                $config['options'],
            );
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
