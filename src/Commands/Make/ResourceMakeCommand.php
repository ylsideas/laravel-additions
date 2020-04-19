<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\ResourceMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ResourceMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->collection()
            ? $this->resolveStubPath('/stubs/resource-collection.stub')
            : $this->resolveStubPath('/stubs/resource.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
