<?php

namespace App\Facades\Support;

class Config
{
    private const string CONFIG_FILES_BASE_PATH = BASE_PATH . 'config/';

    private const string CACHE_KEY_PREFIX = '_app_config_';

    public static function get(string $key, $default = null): mixed
    {
        // File handling.
        $explodedKey = explode('.', $key);
        $filename = array_shift($explodedKey); // Get the file name and remove it from the keys array.
        $fullFilename = self::CONFIG_FILES_BASE_PATH . $filename . '.php';

        if (!file_exists($fullFilename)) {
            throw new \Exception("Config file '{$filename}' not found");
        }

        $cacheKey = self::CACHE_KEY_PREFIX . $filename;
        $fileData = Cache::has($cacheKey) ? Cache::get($cacheKey) : require $fullFilename;

        // Traverse the array using the exploded keys.
        foreach ($explodedKey as $keyPart) {
            if (!is_array($fileData) || !array_key_exists($keyPart, $fileData)) {
                return $default; // Return default if the key does not exist.
            }
            $fileData = $fileData[$keyPart]; // Go deeper into the array.
        }

        return $fileData ?? $default;
    }
}
