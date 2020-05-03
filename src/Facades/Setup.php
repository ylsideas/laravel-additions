<?php

namespace YlsIdeas\LaravelAdditions\Facades;

use Illuminate\Support\Facades\Facade;
use YlsIdeas\LaravelAdditions\SetupApplication;

/**
 * @method static bool on(callable $callable)
 * @method static bool beforeTesting(callable $callable)
 * @method static bool afterTesting(callable $callable)
 */
class Setup extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SetupApplication::class;
    }
}
