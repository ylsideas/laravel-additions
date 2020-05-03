<?php

namespace YlsIdeas\LaravelAdditions;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YlsIdeas\LaravelAdditions\Commands\Setup;

class SetupApplication
{
    /**
     * @var callable
     */
    protected $callable;
    /**
     * @var Application
     */
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function on(callable $callable)
    {
        $this->callable = $callable;
    }

    public function execute(bool $firstTime, InputInterface $input, OutputInterface $output)
    {
        if (! is_callable($this->callable)) {
            throw new \RuntimeException('On setup hook has not been configured.');
        }

        return call_user_func($this->callable, $firstTime, $input, $output);
    }

    public function beforeTesting(callable $callable)
    {
        $this->application->make(Dispatcher::class)->listen(
            CommandStarting::class,
            function (CommandStarting $starting) use ($callable) {
                if ($starting->command !== 'test') {

                    return;
                }

                $callable($starting->input, $starting->output);
            }
        );
    }

    public function afterTesting(callable $callable)
    {
        $this->application->make(Dispatcher::class)->listen(
            CommandFinished::class,
            function (CommandFinished $starting) use ($callable) {
                if ($starting->command !== 'test') {

                    return;
                }

                $callable($starting->input, $starting->output);
            }
        );
    }
}
