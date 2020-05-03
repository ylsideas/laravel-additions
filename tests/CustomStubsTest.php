<?php


namespace YlsIdeas\LaravelAdditions\Tests;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\Tests\Dummy\ConfigurableStubsDummy;

class CustomStubsTest extends TestCase
{
    public function testItProvidesThePathForStubsFromTheClass()
    {
        $dummy = new ConfigurableStubsDummy();
        $dummy->laravel = $this->app;
        $this->assertSame(
            dirname((new \ReflectionClass($dummy))->getFileName()) . '/stubs/job.stub',
            $dummy->getStubPath()
        );
    }

    public function testItProvidesThePathForStubsFromTheBasePath()
    {
        File::copyDirectory(__DIR__ . '/../stubs', base_path('stubs'));
        $dummy = new ConfigurableStubsDummy();
        $dummy->laravel = $this->app;

        $this->assertSame(
            base_path('stubs/job.stub'),
            $dummy->getStubPath()
        );

        if (File::exists(base_path('stubs'))) {
            File::deleteDirectory(base_path('stubs'));
        }
    }

    public function testItProvidesThePathForStubsFromTheAppConfig()
    {
        File::copyDirectory(__DIR__ . '/../stubs', resource_path('stubs'));
        Config::set('app.stubs_path', resource_path());
        $dummy = new ConfigurableStubsDummy();
        $dummy->laravel = $this->app;

        $this->assertSame(
            resource_path('stubs/job.stub'),
            $dummy->getStubPath()
        );

        if (File::exists(resource_path('stubs'))) {
            File::deleteDirectory(resource_path('stubs'));
        }
    }
}
