<?php

namespace YlsIdeas\LaravelAdditions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YlsIdeas\LaravelAdditions\Facades\Setup;

class LaravelAdditionsHooksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Setup::on(function (bool $initialising, Command $command) {
            return $this->onSetup($initialising, $command);
        });

        Setup::beforeTesting(function (InputInterface $input, OutputInterface $output) {
            $this->beforeTesting($input, $output);
        });

        Setup::afterTesting(function (bool $passed, InputInterface $input, OutputInterface $output) {
            $this->afterTesting($passed, $input, $output);
        });
    }

    public function register()
    {
        if (config('laravel_additions.use_setup_command', true)) {
            $this->app->singleton(SetupApplication::class);
        }
    }

    public function onSetup(bool $initialising, Command $command) {
        return true;
    }

    public function beforeTesting(InputInterface $input, OutputInterface $output) {
        File::cleanDirectory(storage_path('logs'));
    }

    public function afterTesting(bool $passed, InputInterface $input, OutputInterface $output) {

    }
}
