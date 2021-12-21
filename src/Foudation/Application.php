<?php

namespace App\Foudation;

use App\DI\Containerable;
use App\DI\HasContainer;
use DI\ContainerBuilder;

final class Application implements Containerable
{
    use HasContainer;

    private array $providers = [];

    public function __construct()
    {
        $this->buildContainer();
    }

    public function set(string $name, mixed $value): void
    {
        $this->container->set($name, $value);
    }

    private function buildContainer(): void
    {
        $builder = new ContainerBuilder();
        $this->container = $builder->build();

        $this->container->set(self::class, $this);
    }

    public function register(string $provider): void
    {
        if (!array_key_exists($provider, $this->providers)) {
            $this->providers[$provider] = null;
        }
    }

    private function isRegistred(string $name): bool
    {
        return array_key_exists($name, $this->providers) && !is_null($this->providers[$name]);
    }

    private function getNoneRegistredProviderNames(): array
    {
        $noneRegistred = array_filter($this->providers, function ($name) {
            return !$this->isRegistred($name);
        }, ARRAY_FILTER_USE_KEY);
        return array_keys($noneRegistred);
    }

    private function getProvider(ServiceProvider|string $provider): ServiceProvider|null
    {
        $provider = is_string($provider) ? $provider : get_class($provider);

        if (!array_key_exists($provider, $this->providers)) {
            return null;
        }

        return $this->providers[$provider] ??= new $provider($this);
    }

    private function registerProviders(): void
    {
        do {
            $names = $this->getNoneRegistredProviderNames();
            foreach ($names as $name) {
                /** @var ServiceProvider */
                $provider = $this->getProvider($name);
                $provider->tryToRegister();
            }
        } while (count($this->getNoneRegistredProviderNames()) > 0);
    }

    private function bootProviders(): void
    {
        $providers = array_values($this->providers);
        /** @var ServiceProvider $provider */
        foreach ($providers as $provider) {
            $provider->tryToBoot();
        }
    }

    public function run(): void
    {
        $this->registerProviders();
        $this->bootProviders();
    }
}
