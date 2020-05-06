<?php

namespace YlsIdeas\LaravelAdditions\Testing;

trait WithApplicationTraitHooks
{
    use SimpleAnnotations;

    /**
     * @before
     */
    public function configureAllAppHooks()
    {
        foreach ($this->methodsWithAnnotation('afterAppCreated') as $method) {
            $this->afterApplicationCreated(function () use ($method) {
                $method->invoke($this);
            });
        }
        foreach ($this->methodsWithAnnotation('beforeAppDestroyed') as $method) {
            $this->beforeApplicationDestroyed(function () use ($method) {
                $method->invoke($this);
            });
        }
    }
}
