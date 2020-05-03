<?php

namespace DummyNamespace;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YlsIdeas\LaravelAdditions\LaravelAdditionsHooksServiceProvider;

class LaravelAdditionsServiceProvider extends LaravelAdditionsHooksServiceProvider
{
    public function onSetup(bool $inital, InputInterface $input, OutputInterface $output) {
        File::cleanDirectory(storage_path('logs'));
        Artisan::call('migrate:fresh', ['seed']);
    }

    public function beforeTesting(InputInterface $input, OutputInterface $output) {
        File::cleanDirectory(storage_path('logs'));
    }

    public function afterTesting(InputInterface $input, OutputInterface $output) {

    }
}
