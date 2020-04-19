<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Routing\Console\ControllerMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ControllerMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
