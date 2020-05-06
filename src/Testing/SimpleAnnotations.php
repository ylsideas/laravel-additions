<?php

namespace YlsIdeas\LaravelAdditions\Testing;

trait SimpleAnnotations
{
    public function methodHasAnnotation($method, string $annotation) : bool
    {
        if (! $method instanceof \ReflectionMethod) {
            $method = new \ReflectionMethod($this, $method);
        }

        return (bool) preg_match(sprintf('/\*\s@%s\s*\n/', preg_quote($annotation)), $method->getDocComment());
    }

    public function methodsWithAnnotation(string $annotation)
    {
        return collect((new \ReflectionClass($this))->getMethods())
            ->filter(function (\ReflectionMethod $method) use ($annotation) {
                return (bool) $method->getDocComment() && $this->methodHasAnnotation($method, $annotation);
            })
            ->toArray();
    }
}
