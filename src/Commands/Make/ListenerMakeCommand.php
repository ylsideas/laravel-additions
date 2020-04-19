<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\ListenerMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ListenerMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function getStub()
    {
        if ($this->option('queued')) {
            return $this->option('event')
                ? $this->resolveStubPath('/stubs/listener-queued.stub')
                : $this->resolveStubPath('/stubs/listener-queued-duck.stub');
        }

        return $this->option('event')
            ? $this->resolveStubPath('/stubs/listener.stub')
            : $this->resolveStubPath('/stubs/listener-duck.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
