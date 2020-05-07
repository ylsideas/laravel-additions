<?php


namespace YlsIdeas\LaravelAdditions\Tests\Testing;


use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\Testing\SimpleAnnotations;
use YlsIdeas\LaravelAdditions\Testing\WithApplicationTraitHooks;

class ApplicationTraitHooksTest extends TestCase
{
    public function testRegistersHooks()
    {
        $testWithAnnotations = new class() {
            use SimpleAnnotations;
            use WithApplicationTraitHooks;

            public $afterFired = false;
            public $beforeFired = false;

            /**
             * @afterAppCreated
             */
            public function afterAppCreatedTest()
            {
                $this->afterFired = true;
            }

            /**
             * @beforeAppDestroyed
             */
            public function beforeAppDestroyedTest()
            {
                $this->beforeFired = true;
            }

            public function afterApplicationCreated(callable $callable)
            {
                $callable();
            }

            public function beforeApplicationDestroyed(callable $callable)
            {
                $callable();
            }
        };

        $testWithoutAnnotations = new class() {
            use WithApplicationTraitHooks;

            public $afterFired = false;
            public $beforeFired = false;

            public function afterAppCreatedTest()
            {
                $this->afterFired = true;
            }

            public function beforeAppDestroyedTest()
            {
                $this->beforeFired = true;
            }

            public function afterApplicationCreated(callable $callable)
            {
                $callable();
            }

            public function beforeApplicationDestroyed(callable $callable)
            {
                $callable();
            }
        };

        $testWithAnnotations->configureAllAppHooks();

        $this->assertTrue($testWithAnnotations->afterFired);
        $this->assertTrue($testWithAnnotations->beforeFired);

        $this->assertFalse($testWithoutAnnotations->afterFired);
        $this->assertFalse($testWithoutAnnotations->beforeFired);
    }
}
