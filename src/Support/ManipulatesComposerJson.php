<?php


namespace YlsIdeas\LaravelAdditions\Support;


use Illuminate\Support\Facades\File;

trait ManipulatesComposerJson
{
    /**
     * @var array
     */
    protected $composerJson;

    protected function loadComposerJson()
    {
        $this->composerJson = json_decode(File::get(base_path('composer.json')), true);

        return $this;
    }

    protected function addFile($file, $dev = false)
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

    protected function storeComposerJson()
    {
        File::put(
            base_path('composer.json'),
            json_encode($this->composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        return $this;
    }
}
