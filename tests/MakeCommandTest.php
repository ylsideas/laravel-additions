<?php


namespace YlsIdeas\LaravelAdditions\Tests;


use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\LaravelAdditionsServiceProvider;
use YlsIdeas\LaravelAdditions\Testing\WithApplicationTraitHooks;

class MakeCommandTest extends TestCase
{
    use WithApplicationTraitHooks;

    /**
     * @afterAppCreated
     */
    public function setUpStubs()
    {
        File::copyDirectory(__DIR__ . '/../stubs', base_path('stubs'));
    }

    /**
     * @beforeAppDestroyed
     */
    public function resetStubs()
    {
        File::deleteDirectory(base_path('stubs'));
    }

    /**
     * @dataProvider commands
     */
    public function testItRunsCustomMakeCommands($command, $parameters, $assert, $cleanup)
    {
        $this->artisan($command, $parameters)->assertExitCode(0);

        $assert();
        $cleanup();
    }

    public function commands()
    {
        return [
            'notifications' => [
                'make:notification',
                ['name' => 'Test'],
                function () {
                    $this->assertFileExists(app_path('Notifications/Test.php'));
                },
                function () {
                    File::deleteDirectory(app_path('Notifications'));
                }
            ],
            'model' => [
                'make:model',
                ['name' => 'Test'],
                function () {
                    $this->assertFileExists(app_path('Test.php'));
                },
                function () {
                    File::delete(app_path('Test.php'));
                }
            ],
            'events' => [
                'make:event',
                ['name' => 'Test'],
                function () {
                    $this->assertFileExists(app_path('Events/Test.php'));
                },
                function () {
                    File::deleteDirectory(app_path('Events'));
                }
            ],
            'listener' => [
                'make:listener',
                ['name' => 'Test'],
                function () {
                    $this->assertFileExists(app_path('Listeners/Test.php'));
                },
                function () {
                    File::deleteDirectory(app_path('Listeners'));
                }
            ]
        ];
    }

    protected function getPackageProviders($app)
    {
        return [LaravelAdditionsServiceProvider::class];
    }
}
