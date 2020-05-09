<?php


namespace YlsIdeas\LaravelAdditions\Tests;


use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\LaravelAdditionsServiceProvider;
use YlsIdeas\LaravelAdditions\Testing\SimpleAnnotations;
use YlsIdeas\LaravelAdditions\Testing\WithApplicationTraitHooks;
use YlsIdeas\LaravelAdditions\Tests\Support\ManipulatesComposerJson;

class ConfigureCommandsTest extends TestCase
{
    use ManipulatesComposerJson;
    use SimpleAnnotations;
    use WithApplicationTraitHooks;

    /**
     * @afterAppCreated
     */
    public function backupComposerJson()
    {
        File::makeDirectory(base_path('tests'));
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
        File::deleteDirectory(base_path('tests'));
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

    public function testItConfiguresTheDevHelpersFile()
    {
        $this->artisan('configure:helpers', ['--dev' => true])->assertExitCode(0);

        $this->assertFileExists(base_path('tests/helpers.php'));

        $this->loadComposerJson()
            ->assertDevFileAutoLoaded('tests/helpers.php');

        File::delete(base_path('tests/helpers.php'));
    }

    public function testItConfiguresTheMacrosFile()
    {
        $this->artisan('configure:macros')->assertExitCode(0);

        $this->assertFileExists(app_path('macros.php'));

        $this->loadComposerJson()
            ->assertFileAutoLoaded('app/macros.php');

        File::delete(app_path('macros.php'));
    }

    public function testItConfiguresTheDevMacrosFile()
    {
        $this->artisan('configure:macros', ['--dev' => true])->assertExitCode(0);

        $this->assertFileExists(base_path('tests/macros.php'));

        $this->loadComposerJson()
            ->assertDevFileAutoLoaded('tests/macros.php');

        File::delete(base_path('tests/macros.php'));
    }

    public function testItConfiguresTheNameInComposerJson()
    {
        $this->artisan('configure:composer', ['--name' => 'ylsideas/test-project'])
            ->assertExitCode(0);

        $this->loadComposerJson()
            ->assertName('ylsideas/test-project');
    }

    public function testItConfiguresTheLicenseByOptionInComposerJson()
    {
        $this->artisan('configure:composer', ['--license' => 'proprietary'])
            ->assertExitCode(0);

        $this->loadComposerJson()
            ->assertLicense('proprietary');
    }

    public function testItConfiguresTheLicenseByAskingInComposerJson()
    {
        $this->artisan('configure:composer', ['--license' => true])
            ->expectsQuestion('Which license should be used?', 'proprietary')
            ->assertExitCode(0);

        $this->loadComposerJson()
            ->assertLicense('proprietary');
    }

    public function testItConfiguresTheDescriptionInComposerJson()
    {
        $this->artisan('configure:composer', ['--description' => true])
            ->expectsQuestion('Describe your project: ', 'This is a laravel experiment.')
            ->assertExitCode(0);

        $this->loadComposerJson()
            ->assertDescription('This is a laravel experiment.');
    }

    public function testItConfiguresTheKeywordsInComposerJson()
    {
        $this->artisan('configure:composer', ['--keyword' => ['experiment', 'application']])
            ->assertExitCode(0);

        $this->loadComposerJson()
            ->assertKeywords([
                'application',
                'experiment'
            ]);
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
