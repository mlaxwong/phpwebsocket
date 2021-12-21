<?php

namespace App\DI;

use DI\Container;

trait HasContainer
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @template T
     * @param string|class-string<T> $name Entry name or a class name.
     * @return mixed|T
     */
    public function get(string $name)
    {
        return $this->container->get($name);
    }

    /**
     * @template T
     * @param string|class-string<T> $name Entry name or a class name.
     * @return mixed|T
     */
    public function has(string $name)
    {
        return $this->container->has($name);
    }

    /**
     * @template T
     * @param string|class-string<T> $name
     * @param array                  $parameters
     * @return mixed|T
     */
    public function make($name, array $parameters = [])
    {
        return $this->container->make($name, $parameters);
    }

    /**
     * @param callable $callable
     * @param array    $parameters
     * @return mixed
     */
    public function call($callable, array $parameters = [])
    {
        return $this->container->call($callable, $parameters);
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}
