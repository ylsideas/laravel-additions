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
    protected $name = 'configure:helpers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure and make a helpers file';

    public function handle(Composer $composer)
    {
        $this->loadComposerJson();
        $this->createFile(app_path('helpers.php'));
        $this->addFile('app/helpers.php');
        $this->storeComposerJson();
        $composer->dumpAutoloads();
    }

    protected function createFile(string $filePath)
    {
        File::put($filePath, '<?php' . PHP_EOL);

        return $this;
    }
}
