<?php

namespace YlsIdeas\LaravelAdditions\Tests\Dummy;

use Illuminate\Console\Command;

class TestCommandDummy extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dummy for running tests.';

    public function handle()
    {

    }
}
