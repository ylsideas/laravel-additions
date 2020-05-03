<?php

namespace YlsIdeas\LaravelAdditions;

use Hamcrest\Core\Set;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YlsIdeas\LaravelAdditions\Facades\Setup;

class LaravelAdditionsHooksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Setup::on(function (bool $inital, InputInterface $input, OutputInterface $output) {
            return $this->onSetup($inital, $input, $output);
        });

        Setup::beforeTesting(function (InputInterface $input, OutputInterface $output) {
            $this->beforeTesting($input, $output);
        });

        Setup::afterTesting(function (InputInterface $input, OutputInterface $output) {
            $this->afterTesting($input, $output);
        });
    }

    public function register()
    {
        if (config('laravel_additions.use_setup_command', true)) {
            $this->app->singleton(SetupApplication::class);
        }
    }

    public function onSetup(bool $inital, InputInterface $input, OutputInterface $output) {
        return true;
    }

    public function beforeTesting(InputInterface $input, OutputInterface $output) {
        File::cleanDirectory(storage_path('logs'));
    }

    public function afterTesting(InputInterface $input, OutputInterface $output) {

    }
}
