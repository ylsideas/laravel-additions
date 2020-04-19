<?php


namespace YlsIdeas\LaravelAdditions\Support;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;

/**
 * @mixin GeneratorCommand
 */
trait ConfiguresStubs
{
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     * @throws \ReflectionException
     */
    protected function resolveStubPath($stub)
    {
        $config = $this->laravel->make('config');

        $customPath = $config->get('app.stubs_path', false) ?
            $config->get('app.stubs_path') . $stub :
            $this->laravel->basePath(trim($stub, '/'));

        return File::exists($customPath)
            ? $customPath
            : dirname((new \ReflectionClass($this->resolveStubbingClass()))->getFileName()) . $stub;
    }

    protected abstract function resolveStubbingClass();
}
