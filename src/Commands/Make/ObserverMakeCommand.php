<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\ObserverMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ObserverMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function getStub()
    {
        return $this->option('markdown')
            ? $this->resolveStubPath('/stubs/markdown-notification.stub')
            : $this->resolveStubPath('/stubs/notification.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
