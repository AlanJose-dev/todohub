<?php

namespace App\Facades;

use PDO;

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
}
