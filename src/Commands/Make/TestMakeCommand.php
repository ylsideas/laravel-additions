<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\TestMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class TestMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
