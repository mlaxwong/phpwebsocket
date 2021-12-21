<?php

namespace Tests;

use ReflectionClass;

trait Invokable
{
    public function invokeProperty(mixed $class, string $property, mixed $value = null): mixed
    {
        $reflection = new ReflectionClass($class);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        if (func_num_args() > 2) {
            $property->setValue($class, $value);
        }
        return $property->getValue($class);
    }

    public function invokeMethod(mixed $class, string $method, array $argument = []): mixed
    {
        $reflection = new ReflectionClass($class);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($class, $argument);
    }
}
