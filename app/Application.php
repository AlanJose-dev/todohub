<?php

namespace App;

class Application
{
    private static ServiceContainer $serviceContainer;

    public static function setServiceContainer(ServiceContainer $serviceContainer): void
    {
        self::$serviceContainer = $serviceContainer;
    }

    public static function getServiceContainer(): ServiceContainer
    {
        return self::$serviceContainer;
    }
}
