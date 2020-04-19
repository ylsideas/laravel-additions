<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\RuleMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class RuleMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
