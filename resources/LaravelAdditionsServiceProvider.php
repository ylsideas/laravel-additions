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
        Artisan::call('migrate:fresh', ['--seed' => true]);

        return true;
    }

    public function beforeTesting(InputInterface $input, OutputInterface $output) {
    }

    public function afterTesting(InputInterface $input, OutputInterface $output) {
    }
}
