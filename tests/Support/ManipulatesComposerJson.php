<?php


namespace YlsIdeas\LaravelAdditions\Tests\Support;


use PHPUnit\Framework\Assert;
use YlsIdeas\LaravelAdditions\Support\ManipulatesComposerJson as BaseTrait;

trait ManipulatesComposerJson
{
    use BaseTrait;

    public function assertFileAutoLoaded(string $filePath)
    {
        Assert::assertContains($filePath, data_get($this->composerJson, 'autoload.files', []));
    }
}
