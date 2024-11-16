<?php

namespace App\Facades;

class Config
{
    private const string CONFIG_FILES_BASE_PATH = BASE_PATH . 'config/';

    private const string CACHE_KEY_PREFIX = '_app_config_';

    public static function get(string $key, $default = null): mixed
    {
        //File handling.
        $explodedKey = explode('.', $key);
        $filename = $explodedKey[0];
        $fullFilename = self::CONFIG_FILES_BASE_PATH . $filename . '.php';
        if (!file_exists($fullFilename)) {
            throw new \Exception("Config file '{$filename}' not found");
        }

        unset($explodedKey[0]); // Removing the file name index.
        $cacheKey = self::CACHE_KEY_PREFIX . $filename;
        $fileData = Cache::has($cacheKey) ? Cache::get($cacheKey) : require $fullFilename;
        $crawlArray = function() use ($fileData, $explodedKey) {
            $requestedData = null;
            foreach ($explodedKey as $key) {
                $requestedData = $fileData[$key];
            }
            return $requestedData;
        };
        return count($explodedKey) > 0 ? $crawlArray() ?? $default : $fileData;
    }
}
