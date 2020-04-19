<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\ProviderMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ProviderMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function getStub()
    {
        return $this->resolveStubPath('/stub/provider.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
