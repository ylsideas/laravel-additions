<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Database\Console\Seeds\SeederMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class SeederMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
