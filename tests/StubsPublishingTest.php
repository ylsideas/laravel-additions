<?php

namespace YlsIdeas\LaravelAdditions\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\LaravelAdditionsServiceProvider;

class StubsPublishingTest extends TestCase
{
    public function testItCreatesTheStubsFolder()
    {
        Config::set('app.stubs_path', resource_path('stubs'));

        $this->artisan('stub:publish')->assertExitCode(0);

        $this->assertDirectoryExists(resource_path('stubs'));

        if (File::exists(resource_path('stubs'))) {
            File::deleteDirectory(resource_path('stubs'));
        }
    }

    protected function getPackageProviders($app)
    {
        return [LaravelAdditionsServiceProvider::class];
    }
}
