<?php

namespace Core\Providers;

use Core\Facades\Cache;

class EnvProvider
{
    private const string ENV_FILE = BASE_PATH . 'env.json';

    private const string ENV_CACHE_KEY = SERVICE_KEY_PREFIX . 'env';

    private const string ENV_CACHE_TIMESTAMP_KEY = self::ENV_CACHE_KEY . '_timestamp';

    private static function loadEnvPayload(array $data): void
    {
        foreach ($data as $key => $value) {
            $_ENV[$key] = $value;
        }
    }

    public static function init(): void
    {
        if(!file_exists(self::ENV_FILE)) {
            throw new \RuntimeException('Env file does not exist');
        }

        $envIsCached = Cache::has(self::ENV_CACHE_KEY);
        $cachedTimestamp = Cache::get(self::ENV_CACHE_TIMESTAMP_KEY);
        $envFileModifiedTime = filemtime(self::ENV_FILE);

        if(!$envIsCached || !$envFileModifiedTime ||$envFileModifiedTime > $cachedTimestamp) {
            $envFileContents = json_decode(file_get_contents( self::ENV_FILE), true);
            self::loadEnvPayload($envFileContents);
            Cache::set(self::ENV_CACHE_KEY, $envFileContents);
            Cache::set(self::ENV_CACHE_TIMESTAMP_KEY, $envFileModifiedTime);
        }
        else {
            self::loadEnvPayload(Cache::get(self::ENV_CACHE_KEY));
        }
    }
}
