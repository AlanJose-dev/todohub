<?php

namespace App\Facades\Support;

use PDO;
use PDOStatement;

class DB
{
    private static ?PDO $connection = null;

    public static function init(string $key): bool
    {
        $cacheKey = "_app_database_$key";
        $buildDsn = function (array &$configData) use ($key) {
            $dsn = "$key:";
            unset(
                $configData['driver'],
                $configData['user'],
                $configData['password'],
            );
            foreach ($configData as $key => $value) {
                if ($key === 'options') continue;
                $dsn .= "{$key}={$value};";
            }
            return $dsn;
        };

        if (Cache::has($cacheKey)) {
            $databaseConfigData = Cache::get($cacheKey);
            $dsn = $buildDsn($databaseConfigData);
            self::$connection = new PDO(
                $dsn,
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                $databaseConfigData['options']
            );
            return true;
        }
        $databaseConfigData = Config::get("database.connections.{$key}");
        $dsn = $buildDsn($databaseConfigData);
        Cache::set($cacheKey, $databaseConfigData);
        self::$connection = new PDO(
            $dsn,
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            $databaseConfigData['options']
        );
        return true;
    }

    public static function connection(): PDO
    {
        return self::$connection;
    }

    public static function insert(string $table, array $data): bool
    {
        $columns = array_keys($data);
        $binds = array_map(fn($column) => ":$column", $columns);
        $sql = "insert into $table (" . implode(', ', $columns) . ') values (' . implode(', ', $binds) . ')';
        $statement = app()->resolve('_database')->prepare($sql);
        return $statement->execute($data);
    }

    public static function query(string $sql, array $params = []): ?array
    {
        $statement = app()->resolve('_database')->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    public static function queryLazy(string $sql, array $params = []): \Generator
    {
        $statement = app()->resolve('_database')->prepare($sql);
        $statement->execute($params);
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            yield $row;
        }
    }

    public static function update(string $table, array $data, string $targetColumn, string $operand, int $targetColumnValue): bool
    {
        $data[$targetColumn] = $targetColumnValue;
        $columns = array_keys($data);
        $binds = array_map(fn($column) => "$column = :$column", $columns);
        $sql = "update $table set " . implode(', ', $binds) . " where $targetColumn $operand :$targetColumn";
        $statement = app()->resolve('_database')->prepare($sql);
        return $statement->execute($data);
    }

    public static function delete(string $table, string $targetColumn, string $operator, int $targetColumnValue): bool
    {
        $sql = "delete from $table where $targetColumn $operator ?";
        $statement = app()->resolve('_database')->prepare($sql);
        return $statement->execute([$targetColumnValue]);
    }

    public static function truncate(string $table, bool $force = false): bool
    {
        $sql = $force ? 'set foreign_key_checks = 0;' : '';
        $sql .= "truncate $table;";
        $sql .= $force ? 'set foreign_key_checks = 1;' : '';
        $statement = app()->resolve('_database')->prepare($sql);
        return $statement->execute();
    }
}
