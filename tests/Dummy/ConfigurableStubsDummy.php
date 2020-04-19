<?php


namespace YlsIdeas\LaravelAdditions\Tests\Dummy;


use YlsIdeas\LaravelAdditions\Support\ConfiguresStubs;

class ConfigurableStubsDummy
{
    use ConfiguresStubs;

    /**
     * The Laravel application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    public $laravel;

    public function getStubPath()
    {
        return $this->resolveStubPath('/stubs/job.stub');
    }

    protected function resolveStubbingClass()
    {
        return $this;
    }
}
