<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\ComponentMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ComponentMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/view-component.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
