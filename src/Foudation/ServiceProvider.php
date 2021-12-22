<?php

namespace App\Foudation;

use App\DI\Containerable;
use App\DI\HasContainer;
use DI\Container;

class ServiceProvider implements Containerable
{
    use HasContainer;

    private array $providers = [];

    public function __construct(
        protected Application $app
    ) {
        $this->container = $app->getContainer();
    }

    public function register(): void
    {

    }

    public function tryToRegister(): void
    {
        $this->register();
    }

    public function tryToBoot(): void
    {
        if (method_exists($this, 'boot')) {
            $this->app->call([$this, 'boot']);
        }
    }
}
