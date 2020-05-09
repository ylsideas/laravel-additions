<?php

namespace YlsIdeas\LaravelAdditions\Support;

use Illuminate\Support\Facades\File;

class ComposerFile
{
    /**
     * @var array
     */
    protected $composerJson;

    public static function loadComposerJson(string $composer)
    {
        return new self(json_decode($composer, true));
    }

    public function __construct(array $composerJson)
    {
        $this->composerJson = $composerJson;
    }

    public function addFile($file, $dev = false)
    {
        $files = collect(data_get($this->composerJson, $dev ? 'autoload-dev.files' : 'autoload.files', []))
            ->push($file)
            ->unique()
            ->sort()
            ->values()
            ->toArray();
        data_set($this->composerJson, $dev ? 'autoload-dev.files' : 'autoload.files', $files);

        return $this;
    }

    public function setName(string $provider, string $package)
    {
        data_set($this->composerJson, 'name', implode('/', [$provider, $package]));

        return $this;
    }

    public function setLicense(string $license)
    {
        data_set($this->composerJson, 'license', $license);

        return $this;
    }

    public function toJson()
    {
        return json_encode($this->composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function setDescription($description)
    {
        data_set($this->composerJson, 'description', $description);

        return $this;
    }

    public function setKeywords(array $keywords)
    {
        data_set($this->composerJson, 'keywords', $keywords);

        return $this;
    }
}
