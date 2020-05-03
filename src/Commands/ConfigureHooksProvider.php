<?php

namespace YlsIdeas\LaravelAdditions\Commands;

use Illuminate\Console\GeneratorCommand as Command;

class ConfigureHooksProvider extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'configure:hooks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply a hooks provider to the application';

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return 'LaravelAdditionsServiceProvider';
    }

    protected function getStub()
    {
        return __DIR__ . '/../../resources/LaravelAdditionsServiceProvider.php';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Providers';
    }

    public function info($string, $verbosity = null)
    {
        $this->line('Laravel Additions Hooks Provider installed, add to config/app.php', 'info', $verbosity);
    }

    protected function getArguments()
    {
        return [];
    }
}
