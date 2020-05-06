<?php

namespace YlsIdeas\LaravelAdditions\Testing;

use Illuminate\Foundation\Testing\TestCase;

trait WithoutExceptionHandling
{
    use SimpleAnnotations;

    /**
     * @var array
     */
    protected $excludedExceptionsToHandle = [];

    /**
     * @afterAppCreated
     */
    public function runTestWithoutExceptionHandler()
    {
        if ($this->methodHasAnnotation($this->getName(), 'withoutExceptionHandling')) {
            $this->withoutExceptionHandling($this->excludedExceptionsToHandle());
        }
    }

    public function excludedExceptionsToHandle()
    {
        return $this->excludedExceptionsToHandle;
    }
}
