<?php


namespace YlsIdeas\LaravelAdditions\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use YlsIdeas\LaravelAdditions\Support\ManipulatesComposerJson;

class Configure extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ylsideas:configure {--helpers|-p} {--macros|-m}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure and make a helpers file';

    public function handle()
    {
        if ($this->option('helpers')) {
            $this->call('ylsideas:configure:helpers');
        }
        if ($this->option('macros')) {
            $this->call('ylsideas:configure:macros');
        }
    }
}
