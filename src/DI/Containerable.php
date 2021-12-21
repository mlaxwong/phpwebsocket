<?php

namespace App\DI;

use DI\Container;
use DI\FactoryInterface;
use Invoker\InvokerInterface;
use Psr\Container\ContainerInterface;

interface Containerable extends ContainerInterface, FactoryInterface, InvokerInterface
{
    public function getContainer(): Container;
}
