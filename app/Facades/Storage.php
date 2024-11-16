<?php

namespace App\Facades;

class Storage
{
    private static array $disk;

    private static function diskToPath(string $disk): string
    {
        $explodedRoot = explode('/', $disk);
        return end($explodedRoot);
    }

    public static function init(string $disk): bool
    {
        self::$disk = config("filesystems.disks.$disk");
        return true;
    }

    public static function disk(string $disk): self
    {
        self::init($disk);
        return new static();
    }

    public static function putContent(string $file, string $content): bool
    {
        $diskAsPath = self::diskToPath(self::$disk['root']);
        $fullPath = storage_path("app/$diskAsPath/$file");
        file_put_contents($fullPath, $content);
        return true;
    }

    public static function getContent(string $file): mixed
    {
        $diskAsPath = self::diskToPath(self::$disk['root']);
        $fullPath = storage_path("app/$diskAsPath/$file");
        return file_get_contents($fullPath);
    }
}
