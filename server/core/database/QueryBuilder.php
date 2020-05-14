<?php

namespace App\Core\Database;

class QueryBuilder {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function selectAll($table) {
        $statement = $this->pdo->prepare("SELECT * FROM {$table}");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectOne($table, $parameters, $columns) {
        $sql = sprintf(
            'SELECT %s FROM %s WHERE %s',
            implode(', ', $columns),
            $table,
            implode(' AND ', array_map(fn ($p) => "{$p} = :{$p}", array_keys($parameters))),
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectByAttrValues($table, $parameter, $values, $columns) {
        $sql = sprintf(
            'SELECT %s FROM %s WHERE %s IN (%s)',
            implode(', ', $columns),
            $table,
            $parameter,
            implode(', ', $values),
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($table, $parameters) {
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters)),
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($parameters);
    }

    public function deleteOne($table, $parameters) {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s',
            $table,
            implode(' AND ', array_map(fn ($p) => "{$p} = :{$p}", array_keys($parameters))),
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($parameters);
    }

    public function deleteAll($table) {
        $sql = sprintf(
            'DELETE FROM %s ',
            $table,
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    }

    public function update($table, $parameters, $conditions) {
        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s',
            $table,
            implode(' , ', array_map(fn ($p) => "{$p} = :{$p}", array_keys($parameters))),
            implode(' AND ', array_map(fn ($c) => "{$c} = :{$c}", array_keys($conditions))),
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_merge($parameters, $conditions));
    }
}
