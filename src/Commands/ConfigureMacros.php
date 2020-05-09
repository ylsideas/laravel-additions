<?php


namespace YlsIdeas\LaravelAdditions\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use YlsIdeas\LaravelAdditions\Support\ManipulatesProjectComposerJson;

class ConfigureMacros extends Command
{
    use ManipulatesProjectComposerJson;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'configure:macros {--d|dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure and make a macros file';

    public function handle(Composer $composer)
    {
        $path = app_path('macros.php');
        $relativePath = 'app/macros.php';
        $dev = false;

        if ($this->option('dev') ?? false) {
            $path = base_path('tests/macros.php');
            $relativePath = 'tests/macros.php';
            $dev = true;
        }

        $this->loadComposerJson();
        $this->createFile($path);
        $this->getComposerFile()->addFile($relativePath, $dev);
        $this->storeComposerJson();
        $composer->dumpAutoloads();
    }

    protected function createFile(string $filePath)
    {
        File::put($filePath, '<?php' . PHP_EOL);

        return $this;
    }
}
