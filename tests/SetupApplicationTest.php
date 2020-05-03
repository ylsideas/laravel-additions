<?php

namespace YlsIdeas\LaravelAdditions\Tests;

use Illuminate\Console\Application as Artisan;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YlsIdeas\LaravelAdditions\LaravelAdditionsHooksServiceProvider;
use YlsIdeas\LaravelAdditions\LaravelAdditionsServiceProvider;
use YlsIdeas\LaravelAdditions\SetupApplication;
use YlsIdeas\LaravelAdditions\Tests\Dummy\TestCommandDummy;

class SetupApplicationTest extends TestCase
{
    public function testSetupCommand()
    {
        /** @var SetupApplication $setup */
        $setup = $this->app->make(SetupApplication::class);

        $flag = false;

        $setup->on(function (bool $initalised) use (&$flag) {
            $flag = true;
            $this->assertFalse($initalised);

            return true;
        });

        $this->artisan('setup')->assertExitCode(0);

        $this->assertTrue($flag);
    }

    public function testSetupProvidesInitialisedFlagCommand()
    {
        /** @var SetupApplication $setup */
        $setup = $this->app->make(SetupApplication::class);

        $flag = false;

        $setup->on(function (bool $initalised) use (&$flag) {
            $flag = true;
            $this->assertTrue($initalised);

            return true;
        });

        $this->artisan('setup', ['--initial' => true])->assertExitCode(0);

        $this->assertTrue($flag);
    }

    public function testSetupProvidesExitCodeOne()
    {
        /** @var SetupApplication $setup */
        $setup = $this->app->make(SetupApplication::class);

        $flag = false;

        $setup->on(function (bool $initalised) use (&$flag) {
            $flag = true;
            $this->assertTrue($initalised);

            return false;
        });

        $this->artisan('setup', ['--initial' => true])->assertExitCode(1);

        $this->assertTrue($flag);
    }

    public function testSetupProvidesTheInputAndOutputInterfacesForTheCommand()
    {
        /** @var SetupApplication $setup */
        $setup = $this->app->make(SetupApplication::class);

        $flag = false;

        $setup->on(function (bool $initalised, $input, $output) use (&$flag) {
            $flag = true;
            $this->assertInstanceOf(InputInterface::class, $input);
            $this->assertInstanceOf(OutputInterface::class, $output);

            return true;
        });

        $this->artisan('setup')->assertExitCode(0);

        $this->assertTrue($flag);
    }

    public function testBeforeTestingHook()
    {
        /** @var SetupApplication $setup */
        $setup = $this->app->make(SetupApplication::class);

        $flag = false;

        Artisan::starting(function (Artisan $artisan) {
            $artisan->resolveCommands(TestCommandDummy::class);
        });

        $setup->beforeTesting(function ($input, $output) use (&$flag) {
            $flag = true;
            $this->assertInstanceOf(InputInterface::class, $input);
            $this->assertInstanceOf(OutputInterface::class, $output);
        });

        $this->artisan('test')->assertExitCode(0);

        $this->assertTrue($flag);
    }

    public function testAfterTestingHook()
    {
        /** @var SetupApplication $setup */
        $setup = $this->app->make(SetupApplication::class);

        $flag = false;

        Artisan::starting(function (Artisan $artisan) {
            $artisan->resolveCommands(TestCommandDummy::class);
        });

        $setup->afterTesting(function ($input, $output) use (&$flag) {
            $flag = true;
            $this->assertInstanceOf(InputInterface::class, $input);
            $this->assertInstanceOf(OutputInterface::class, $output);
        });

        $this->artisan('test')->assertExitCode(0);

        $this->assertTrue($flag);
    }

    public function testPublishesItsOwnServiceProvider()
    {
        if (File::exists(app_path('Providers/LaravelAdditionsServiceProvider.php'))) {
            File::delete(app_path('Providers/LaravelAdditionsServiceProvider.php'));
        }

        $this->artisan('configure:hooks')->assertExitCode(0);

        $this->assertFileExists(app_path('Providers/LaravelAdditionsServiceProvider.php'));
        $this->assertStringContainsString(
            'namespace App\Providers;',
            File::get(app_path('Providers/LaravelAdditionsServiceProvider.php'))
        );
    }

    protected function getPackageProviders($app)
    {
        return [LaravelAdditionsServiceProvider::class, LaravelAdditionsHooksServiceProvider::class];
    }
}
