<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\RequestMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class RequestMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
