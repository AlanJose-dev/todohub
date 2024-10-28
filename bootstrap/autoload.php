<?php

spl_autoload_register(function (string $class) {
    $class = str_replace('\\', '/', $class);
    $file = BASE_PATH . $class . '.php';
    if (!file_exists($file)) {
        throw new \Exception("Class $class not found");
    }
    require $file;
});