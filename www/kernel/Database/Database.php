<?php

namespace App\Kernel\Database;

use App\Kernel\Config\ConfigInterface;
use RedBeanPHP\R;
use RedBeanPHP\RedException;

class Database extends R implements DatabaseInterface
{
    private \PDO $pdo;

    public function __construct(
        private ConfigInterface $config
    ) {
        $this->connect();
    }

    public function insert(string $table, array $data): int|false
    {
        $fields = array_keys($data);

        $columns = implode(', ', $fields);
        $binds = implode(', ', array_map(fn($field) => ":$field", $fields));

        $sql = "INSERT INTO $table ($columns) VALUES ($binds)";

        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($data);
        } catch (\PDOException $exception) {
            return false;
        }

        return (int) $this->pdo->lastInsertId();
    }

    public function first(string $table, array $conditions = [], array $column = ['*']): ?array
    {
        $column = implode(', ', $column);
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT $column FROM $table $where LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function get(string $table, array $conditions = [], array $order = [], int $limit = -1, string $select = '*'): array
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT $select FROM $table $where";

        if (count($order) > 0) {
            $sql .= ' ORDER BY ' . implode(', ', array_map(fn($field, $direction) => "$field $direction", array_keys($order), $order));
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete(string $table, array $conditions = []): int
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "DELETE FROM $table $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);
        
        return $stmt->rowCount();
    }

    public function update(string $table, array $data, array $conditions = []): int
    {
        $fields = array_keys($data);

        $set = implode(', ', array_map(fn($field) => "$field = :$field", $fields));
        
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "UPDATE $table SET $set $where";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge($data, $conditions));
        
        return $stmt->rowCount();
    }

    public function execution(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function connect(): void
    {
        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $database = $this->config->get('database.database');
        $username = $this->config->get('database.username');
        $password = $this->config->get('database.password');
        $charset = $this->config->get('database.charset');

        try {
            $this->pdo = new \PDO(
                "$driver:host=$host;port=$port;dbname=$database;charset=$charset",
                $username,
                $password
            );
        } catch (\PDOException $exception) {
            exit("Database connection failed: {$exception->getMessage()}");
        }

        try {
            Database::setup(
                "mysql:host=$host;dbname=$database",
                $username,
                $password
            );
            if (!R::testConnection()) {
                throw new RedException('No connection');
            }
        } catch (RedException $e) {
            dd($e->getMessage());
        }

    }
}