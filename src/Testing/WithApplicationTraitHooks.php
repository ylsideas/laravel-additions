<?php

namespace YlsIdeas\LaravelAdditions\Testing;

trait WithApplicationTraitHooks
{
    private static $AFTER_APP_REGEX = '/\*\s@afterAppCreated\s*\n/';
    private static $BEFORE_APP_REGEX = '/\*\s@beforeAppDestroyed\s*\n/';

    /**
     * @before
     */
    public function configureAllAppHooks()
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getMethods() as $method) {
            $methodName = $method->getName();
            if ($method->getDocComment()) {
                if (preg_match(self::$AFTER_APP_REGEX, $method->getDocComment())) {
                    $this->afterApplicationCreated(function () use ($methodName) {
                        call_user_func([$this, $methodName]);
                    });
                }
                if (preg_match(self::$BEFORE_APP_REGEX, $method->getDocComment())) {
                    $this->beforeApplicationDestroyed(function () use ($methodName) {
                        call_user_func([$this, $methodName]);
                    });
                }
            }
        }
    }
}
