<?php

namespace YlsIdeas\LaravelAdditions\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\StubPublishCommand as BaseCommand;
use Illuminate\Support\Facades\File;

class StubPublishCommand extends BaseCommand
{
    public function handle()
    {
        $stubsPath = config('app.stubs_path', $this->laravel->basePath('stubs'));

        if (! is_dir($stubsPath)) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        collect(File::allFiles(__DIR__ . '/../../stubs'))
            ->filter(function (\SplFileInfo $file) {
                return $file->getExtension() === 'stub';
            })
            ->mapWithKeys(function (\SplFileInfo $file) use ($stubsPath) {
                return [$file->getRealPath() => $stubsPath . '/' . $file->getBasename()];
            })
            ->filter(function ($to, $from) {
                return ! File::exists($to) || $this->option('force');
            })
            ->each(function ($to, $from) {
                File::put($to, File::get($from));
            });

        $this->info('Stubs published successfully.');
    }
}
