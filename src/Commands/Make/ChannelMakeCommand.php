<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\ChannelMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ChannelMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/channel.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
