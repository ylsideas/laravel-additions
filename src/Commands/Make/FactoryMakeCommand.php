<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Database\Console\Factories\FactoryMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class FactoryMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
