<?php

namespace App\Traits\Models;

trait ModelBootWorker
{
    protected static function isImplementedMethod(string $method): bool
    {
        $className = static::class;
        $reflectionClass = new \ReflectionClass(static::class);
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
        $implementedMethods = [];
        foreach ($methods as $method) {
            if ($method->getDeclaringClass()->getName() === $className && !$method->isAbstract()) {
                $implementedMethods[] = $method->getName();
            }
        }
        return in_array($method, $implementedMethods);
    }

    protected static function callBootMethodIfExists(): void
    {
        if(self::isImplementedMethod('boot')) {
            call_user_func_array([static::class, 'boot'], []);
        }
    }

    protected static function removeStandardAttributes(array &$attributes): void
    {
        unset(
            $attributes['table'],
            $attributes['fillableColumns'],
            $attributes['casts'],
            $attributes['connection'],
        );
    }
}
