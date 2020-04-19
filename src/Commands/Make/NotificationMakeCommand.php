<?php

namespace YlsIdeas\LaravelAdditions\Commands\Make;

use Illuminate\Foundation\Console\NotificationMakeCommand as BaseCommand;
use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class NotificationMakeCommand extends BaseCommand
{
    use ConfiguresStubs;

    public function handle()
    {
        parent::handle();
    }

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
