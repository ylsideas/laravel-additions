<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Routing\Console\MiddlewareMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class MiddlewareMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
