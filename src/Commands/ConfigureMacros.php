<?php


namespace YlsIdeas\LaravelAdditions\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use YlsIdeas\LaravelAdditions\Support\ManipulatesComposerJson;

class ConfigureMacros extends Command
{
    use ManipulatesComposerJson;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'configure:macros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure and make a macros file';

    public function handle(Composer $composer)
    {
        $this->loadComposerJson();
        $this->createFile(app_path('macros.php'));
        $this->addFile('app/macros.php');
        $this->storeComposerJson();
        $composer->dumpAutoloads();
    }

    protected function createFile(string $filePath)
    {
        File::put($filePath, '<?php' . PHP_EOL);

        return $this;
    }
}
