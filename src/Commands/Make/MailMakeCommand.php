<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\MailMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class MailMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('markdown')
            ? $this->resolveStubPath('/stubs/markdown-mail.stub')
            : $this->resolveStubPath('/stubs/mail.stub');
    }

    protected function resolveStubbingClass()
    {
        return BaseCommand::class;
    }
}
