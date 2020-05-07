<?php

namespace YlsIdeas\LaravelAdditions\Tests\Testing;

use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\Testing\SimpleAnnotations;
use YlsIdeas\LaravelAdditions\Testing\WithoutExceptionHandling;

class WithoutExceptionHandlingTest extends TestCase
{
    public function testDetectsIfTestsAreUsingWithoutExceptionHandling()
    {
        $testDummy = $this->makeDummy('testAnnotated');

        $testDummy->runTestWithoutExceptionHandler();

        $this->assertTrue($testDummy->ran);
    }

    public function testDetectsIfTestsAreNotUsingWithoutExceptionHandling()
    {
        $testDummy = $this->makeDummy('testNotAnnotated');

        $testDummy->runTestWithoutExceptionHandler();

        $this->assertFalse($testDummy->ran);
    }

    protected function makeDummy($name)
    {
        return new class($name) {
            use SimpleAnnotations;
            use WithoutExceptionHandling;

            protected $name;

            public $ran = false;

            public function __construct($name)
            {
                $this->name = $name;
            }

            public function getName()
            {
                return $this->name;
            }

            public function withoutExceptionHandling($except = [])
            {
                $this->ran = true;
            }

            /**
             * @withoutExceptionHandling
             */
            public function testAnnotated()
            {

            }

            public function testNotAnnotated()
            {

            }
        };
    }
}
