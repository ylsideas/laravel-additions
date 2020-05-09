<?php


namespace YlsIdeas\LaravelAdditions\Tests\Support;


use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert;
use YlsIdeas\LaravelAdditions\Support\ManipulatesProjectComposerJson as BaseTrait;

trait ManipulatesComposerJson
{
    use BaseTrait;

    public function assertFileAutoLoaded(string $filePath)
    {
        Assert::assertContains(
            $filePath,
            data_get(json_decode($this->composerFile->toJson(), true), 'autoload.files', [])
        );
    }

    public function assertDevFileAutoLoaded(string $filePath)
    {
        Assert::assertContains(
            $filePath,
            data_get(json_decode($this->composerFile->toJson(), true), 'autoload-dev.files', [])
        );
    }

    public function assertName(string $name)
    {
        Assert::assertSame(
            $name,
            data_get($this->composerJsonToArray(), 'name', null)
        );
    }

    public function assertLicense(string $license)
    {
        Assert::assertSame(
            $license,
            data_get($this->composerJsonToArray(), 'license', null)
        );
    }

    public function assertDescription(string $description)
    {
        Assert::assertSame(
            $description,
            data_get($this->composerJsonToArray(), 'description', null)
        );
    }

    public function assertKeywords(array $keywords)
    {
        Assert::assertSame(
            Arr::sort($keywords),
            Arr::sort(data_get($this->composerJsonToArray(), 'keywords', []))
        );
    }

    protected function composerJsonToArray()
    {
        return json_decode($this->composerFile->toJson(), true);
    }
}
