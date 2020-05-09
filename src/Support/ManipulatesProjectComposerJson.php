<?php


namespace YlsIdeas\LaravelAdditions\Support;


use Illuminate\Support\Facades\File;

trait ManipulatesProjectComposerJson
{
    /**
     * @var ComposerFile
     */
    protected $composerFile;

    protected function loadComposerJson()
    {
        $this->composerFile = ComposerFile::loadComposerJson(
            File::get(base_path('composer.json'))
        );

        return $this;
    }

    protected function getComposerFile()
    {
        return $this->composerFile;
    }

    protected function storeComposerJson()
    {
        File::put(
            base_path('composer.json'),
            $this->composerFile->toJson()
        );

        return $this;
    }
}
