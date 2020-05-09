<?php

namespace YlsIdeas\LaravelAdditions\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use YlsIdeas\LaravelAdditions\SetupApplication;

class Setup extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a setup procedure';

    public function handle(SetupApplication $application)
    {
        if ($application->execute((bool) $this->option('initial'), $this)) {
            $this->line($this->option('initial') ? 'Initial Setup complete!' : 'Setup complete!');
            return 0;
        }

        $this->error($this->option('initial') ? 'Initial Setup failed!' : 'Setup failed!');
        return 1;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['initial', 'i', InputOption::VALUE_NONE, 'Run the setup for a new installation'],
        ];
    }
}
