<?php


namespace YlsIdeas\LaravelAdditions\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use YlsIdeas\LaravelAdditions\Support\ManipulatesComposerJson;

class ConfigureHelpers extends Command
{
    use ManipulatesComposerJson;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'configure:helpers {--d|dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure and make a helpers file';

    public function handle(Composer $composer)
    {
        $path = app_path('helpers.php');
        $relativePath = 'app/helpers.php';
        $dev = false;

        if ($this->option('dev')) {
            $path = base_path('tests/helpers.php');
            $relativePath = 'tests/helpers.php';
            $dev = true;
        }

        $this->loadComposerJson();
        $this->createFile($path);
        $this->addFile($relativePath, $dev);
        $this->storeComposerJson();
        $composer->dumpAutoloads();
    }

    protected function createFile(string $filePath)
    {
        File::put($filePath, '<?php' . PHP_EOL);

        return $this;
    }
}
