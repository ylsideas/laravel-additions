<?php


namespace YlsIdeas\LaravelAdditions\Tests;


use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\LaravelAdditionsServiceProvider;
use YlsIdeas\LaravelAdditions\Testing\WithApplicationTraitHooks;
use YlsIdeas\LaravelAdditions\Tests\Support\ManipulatesComposerJson;

class ConfigureCommandsTest extends TestCase
{
    use ManipulatesComposerJson;
    use WithApplicationTraitHooks;

    /**
     * @afterAppCreated
     */
    public function backupComposerJson()
    {
        File::copy(base_path('composer.json'), base_path('composer.json.bk'));
        $this->app->make(Composer::class)->dumpAutoloads();
    }

    /**
     * @beforeAppDestroyed
     */
    public function restoreComposerJson()
    {
        File::move(base_path('composer.json.bk'), base_path('composer.json'));
        $this->app->make(Composer::class)->dumpAutoloads();
    }

    protected function getPackageProviders($app)
    {
        return [LaravelAdditionsServiceProvider::class];
    }

    public function testItConfiguresTheHelpersFile()
    {
        $this->artisan('configure:helpers')->assertExitCode(0);

        $this->assertFileExists(app_path('helpers.php'));

        $this->loadComposerJson()
            ->assertFileAutoLoaded('app/helpers.php');

        File::delete(app_path('helpers.php'));
    }

    public function testItConfiguresTheMacrosFile()
    {
        $this->artisan('configure:macros')->assertExitCode(0);

        $this->assertFileExists(app_path('macros.php'));

        $this->loadComposerJson()
            ->assertFileAutoLoaded('app/macros.php');

        File::delete(app_path('macros.php'));
    }

    public function testItConfiguresAll()
    {
        $this->artisan('configure', ['--all' => true])->assertExitCode(0);

        $this->assertFileExists(app_path('macros.php'));
        $this->assertFileExists(app_path('helpers.php'));

        File::delete(app_path('macros.php'));
        File::delete(app_path('helpers.php'));
    }
}
