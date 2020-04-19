<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\ExceptionMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ExceptionMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    protected function getStub()
    {
        if ($this->option('render')) {
            return $this->option('report')
                ? $this->resolveStubPath('/stubs/exception-render-report.stub')
                : $this->resolveStubPath('/stubs/exception-render.stub');
        }

        return $this->option('report')
            ? $this->resolveStubPath('/stubs/exception-report.stub')
            : $this->resolveStubPath('/stubs/exception.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
