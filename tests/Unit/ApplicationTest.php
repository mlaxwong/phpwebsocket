<?php

namespace Tests\Unit;

use App\Foudation\Application;
use App\Foudation\ServiceProvider;
use PHPUnit\Framework\TestCase;
use Tests\Invokable;

class ApplicationTest extends TestCase
{
    use Invokable;

    public function testRegisteredStatus()
    {
        $app = new Application();
        $this->invokeProperty($app, 'providers', [ApplicationTestSampleOneProvider::class => null, ApplicationTestSampleTwoProvider::class => new ApplicationTestSampleTwoProvider($app)]);

        $this->assertFalse($this->invokeMethod($app, 'isRegistred', [ApplicationTestSampleOneProvider::class]));
        $this->assertTrue($this->invokeMethod($app, 'isRegistred', [ApplicationTestSampleTwoProvider::class]));

        $this->assertEquals([ApplicationTestSampleOneProvider::class], $this->invokeMethod($app, 'getNoneRegistredProviderNames'));
    }

    public function testRegister()
    {
        $app = new Application();
        $this->assertEquals([], $this->invokeProperty($app, 'providers'));

        $app->register(ApplicationTestSampleOneProvider::class);
        $this->assertEquals([ApplicationTestSampleOneProvider::class => null], $this->invokeProperty($app, 'providers'));

        $app->register(ApplicationTestSampleTwoProvider::class);
        $this->assertEquals([ApplicationTestSampleOneProvider::class => null, ApplicationTestSampleTwoProvider::class => null], $this->invokeProperty($app, 'providers'));
    }

    public function testRegisterProviders()
    {
        $app = new Application();
        $this->assertEquals([], $this->invokeProperty($app, 'providers'));

        $app->register(ApplicationTestSampleOneProvider::class);
        $app->register(ApplicationTestSampleTwoProvider::class);
        $app->register(ApplicationTestSampleThreeProvider::class);

        $this->invokeMethod($app, 'registerProviders');
        $this->assertEquals([
            ApplicationTestSampleOneProvider::class => new ApplicationTestSampleOneProvider($app),
            ApplicationTestSampleTwoProvider::class => new ApplicationTestSampleTwoProvider($app),
            ApplicationTestSampleThreeProvider::class => new ApplicationTestSampleThreeProvider($app),
            ApplicationTestSampleFourProvider::class => new ApplicationTestSampleFourProvider($app),
            ApplicationTestSampleFiveProvider::class => new ApplicationTestSampleFiveProvider($app),
        ], $this->invokeProperty($app, 'providers'));
    }
}

class ApplicationTestSampleOneProvider extends ServiceProvider{}
class ApplicationTestSampleTwoProvider extends ServiceProvider{}
class ApplicationTestSampleThreeProvider extends ServiceProvider{
    public function register(): void
    {
        $this->app->register(ApplicationTestSampleFourProvider::class);
        $this->app->register(ApplicationTestSampleFiveProvider::class);
    }
}
class ApplicationTestSampleFourProvider extends ServiceProvider{}
class ApplicationTestSampleFiveProvider extends ServiceProvider{}
