<?php

namespace Core\App;

/*********************************************************
 * The Application class allows access to service container
 * and manage singleton instances.
 ********************************************************/
class Application
{
    /**
     * ServiceContainer after services binding.
     * @var ServiceContainer
     */
    private static ServiceContainer $serviceContainer;

    /**
     * Set the service container.
     * @param ServiceContainer $serviceContainer
     * @return void
     */
    public static function setServiceContainer(ServiceContainer $serviceContainer): void
    {
        self::$serviceContainer = $serviceContainer;
    }

    /**
     * Get the service container instance.
     * @return ServiceContainer
     */
    public static function getServiceContainer(): ServiceContainer
    {
        return self::$serviceContainer;
    }
}
