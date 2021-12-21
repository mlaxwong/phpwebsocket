<?php

namespace Tests\Unit;

use App\Foudation\Application;
use App\Foudation\ServiceProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ServiceProviderTest extends TestCase
{
    public function testBoot()
    {
        /** @var MockObject|ServiceProvider */
        $serviceProvider = $this->getMockForAbstractClass(ServiceProvider::class, arguments:[new Application()], mockedMethods: ['boot']);
        $serviceProvider->expects($this->once())->method('boot');
        $serviceProvider->tryToBoot();
    }

    // public function testBootInjection()
    // {
    //     $cat = new ServiceProviderTestCat();

    //     $container = new Container();
    //     $container->set(ServiceProviderTestCat::class, $cat);

    //     $serviceProvider = new class ($container) extends ServiceProvider  {
    //         public static mixed $injected = null;
    //         public function boot(ServiceProviderTestCat $cat, string | null $test = null) {
    //             self::$injected = $cat;
    //         }
    //     };

    //     $this->assertNull($serviceProvider::$injected);

    //     $serviceProvider->tryToBoot();
    //     $this->assertSame($cat, $serviceProvider::$injected);
    // }
}


class ServiceProviderTestCat
{
    public function cry(): string
    {
        return 'meow~~~';
    }
}
