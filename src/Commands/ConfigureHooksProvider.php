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
    protected $signature = 'configure:hooks';

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
        $this->line(
            'Laravel Additions Hooks Provider installed, now add to config/app.php!',
            'info',
            $verbosity
        );
    }

    public function error($string, $verbosity = null)
    {
        $this->line('Laravel Additions Hooks Provider already installed!', 'error', $verbosity);
    }

    protected function getArguments()
    {
        return [];
    }
}
