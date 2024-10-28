<?php
/**********************************
 * Application bootstrap file.
 *********************************/

/**********************************************
 * Registering classes autoloader function.
 *********************************************/

use Core\App\ServiceContainer;

spl_autoload_register(function (string $class) {
    $class = str_replace('\\', '/', $class);
    $file = BASE_PATH . $class . '.php';
    if (!file_exists($file)) {
        throw new \Exception("Class $class not found");
    }
    require $file;
});

/*******************************************************
 * Instantiating ServiceContainer and binding services.
 ******************************************************/
$serviceContainer = new ServiceContainer();

/*****************************************
 * Setting application service container.
 ****************************************/
\Core\App\Application::setServiceContainer($serviceContainer);


/********************************
 * Initializing providers.
 *******************************/
\Core\Providers\EnvProvider::init();