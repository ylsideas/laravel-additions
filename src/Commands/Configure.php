<?php


namespace YlsIdeas\LaravelAdditions\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use YlsIdeas\LaravelAdditions\Support\ManipulatesComposerJson;

class Configure extends Command
{
    /**
     * @var string
     */
    protected $signature = 'configure
        {--p|helpers}
        {--m|macros}
        {--k|hooks}
        {--a|all}';

    /**
     * @var string
     */
    protected $description = 'Configure all additions from YLS Ideas';

    public function handle()
    {
        if ($this->option('helpers') || $this->option('all')) {
            $this->call('configure:helpers');
        }
        if ($this->option('macros') || $this->option('all')) {
            $this->call('configure:macros');
        }
        if ($this->option('hooks') || $this->option('all')) {
            $this->call('configure:hooks');
        }
    }
}
