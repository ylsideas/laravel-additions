<?php

namespace DummyNamespace;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YlsIdeas\LaravelAdditions\LaravelAdditionsHooksServiceProvider;

class LaravelAdditionsServiceProvider extends LaravelAdditionsHooksServiceProvider
{
    public function onSetup(bool $initialising, Command $command) {
        $command->call('migrate:fresh', ['--seed' => true]);

        return true;
    }

    public function beforeTesting(InputInterface $input, OutputInterface $output) {
    }

    public function afterTesting(bool $passed, InputInterface $input, OutputInterface $output) {
    }
}
