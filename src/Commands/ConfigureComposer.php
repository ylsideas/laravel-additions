<?php

namespace YlsIdeas\LaravelAdditions\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use YlsIdeas\LaravelAdditions\Support\ManipulatesProjectComposerJson;

class ConfigureComposer extends Command
{
    use ManipulatesProjectComposerJson;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'configure:composer
        {--l|license : License for the project}
        {--na|name= : Name of the project}
        {--d|description : Description of the project}
        {--k|keyword=* : Keywords for the project}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure and make a helpers file';

    protected static $licenseTypes = [
        'proprietary' => 'proprietary',
        'apache' => 'Apache-2.0',
        'bsd2' => 'BSD-2-Clause',
        'bsd3' => 'BSD-3-Clause',
        'bsd4' => 'BSD-4-Clause',
        'gpl2' => 'GPL-2.0-only / GPL-2.0-or-later',
        'gpl3' => 'GPL-3.0-only / GPL-3.0-or-later',
        'lgpl2' => 'LGPL-2.1-only / LGPL-2.1-or-later',
        'lgpl3' => 'LGPL-3.0-only / LGPL-3.0-or-later',
        'mit' => 'MIT',
    ];

    public function handle()
    {
        $this->loadComposerJson();
        if (! $this->changeName()) {
            return 1;
        }
        $this->changeLicense();
        $this->changeDescription();
        $this->changeKeywords();
        $this->storeComposerJson();
        return 0;
    }

    protected function changeName()
    {
        if (is_string($this->option('name'))) {
            if (! preg_match('/^[a-z-]+\/[a-z-]+$/', $this->option('name'))) {
                $this->error('Composer name must be in format: provider/package e.g. ylsideas/laravel-additions');
                return false;
            }
            list($provider, $package) = explode('/', $this->option('name'));

            $this->getComposerFile()->setName($provider, $package);
        }

        return true;
    }

    protected function changeLicense()
    {
        if ($this->option('license') && is_string($this->option('license'))) {
            if (! array_key_exists($this->option('license'), self::$licenseTypes)) {
                $this->warn(
                    sprintf(
                        'License should be one of the following: %s',
                        implode(', ', self::$licenseTypes)
                    )
                );
                $this->getComposerFile()->setLicense($this->option('license'));
            } else {
                $this->getComposerFile()->setLicense(self::$licenseTypes[$this->option('license')]);
            }
        } elseif ($this->option('license')) {
            $value = $this->askWithCompletion(
                'Which license should be used?',
                array_values(self::$licenseTypes),
                'proprietary'
            );
            $this->getComposerFile()->setLicense($value);
        }

        return true;
    }

    protected function changeDescription()
    {
        if ($this->option('description')) {
            $description = $this->ask('Describe your project: ');
            $this->getComposerFile()->setDescription($description);
        }

        return true;
    }

    protected function changeKeywords()
    {
        if (count($this->option('keyword') ?? []) > 0) {
            $this->getComposerFile()->setKeywords(
                collect($this->option('keyword'))
                    ->unique()
                    ->filter(function ($keyword) {
                        return is_string($keyword);
                    })
                    ->sort()
                    ->values()
                    ->toArray()
            );
        }

        return true;
    }
}
