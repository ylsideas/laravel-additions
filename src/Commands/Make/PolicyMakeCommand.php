<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\PolicyMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class PolicyMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
