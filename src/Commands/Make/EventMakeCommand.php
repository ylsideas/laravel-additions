<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\EventMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class EventMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/notification.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
