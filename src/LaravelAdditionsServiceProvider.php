<?php

namespace YlsIdeas\LaravelAdditions;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider;
use YlsIdeas\LaravelAdditions\Commands;

class LaravelAdditionsServiceProvider extends ServiceProvider
{
    protected $makeCommands = [
        'ChannelMake' => 'command.channel.make',
        'ComponentMake' => 'command.component.make',
        'ConsoleMake' => 'command.console.make',
        'ControllerMake' => 'command.controller.make',
        'EventMake' => 'command.event.make',
        'ExceptionMake' => 'command.exception.make',
        'FactoryMake' => 'command.factory.make',
        'JobMake' => 'command.job.make',
        'ListenerMake' => 'command.listener.make',
        'MailMake' => 'command.mail.make',
        'MiddlewareMake' => 'command.middleware.make',
        'ModelMake' => 'command.model.make',
        'NotificationMake' => 'command.notification.make',
        'ObserverMake' => 'command.observer.make',
        'PolicyMake' => 'command.policy.make',
        'ProviderMake' => 'command.provider.make',
        'RequestMake' => 'command.request.make',
        'ResourceMake' => 'command.resource.make',
        'RuleMake' => 'command.rule.make',
        'TestMake' => 'command.test.make',
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('ylsideas.php'),
            ], 'config');

            if (config('ylsideas.use_configure_commands', true)) {
                $this->commands(config('ylsideas.use_configure_commands', [
                    Commands\Configure::class,
                    Commands\ConfigureHelpers::class,
                    Commands\ConfigureMacros::class,
                ]));
            }

            if (config('app.stubs_path')) {
                $this->app->singleton('migration.creator', function ($app) {
                    return new MigrationCreator($app['files'], config('app.stubs_path'));
                });
            }
        }
    }

    public function register()
    {
        if (config('ylsideas.use_custom_make_commands', true)) {
            foreach ($this->makeCommands as $command => $singleton)
            $this->extendCommand(
                $singleton,
                "\\YlsIdeas\\LaravelAdditions\\Commands\\Make\\{$command}Command"
            );
            $this->app->extend($singleton, function ($command, $app) {
                return new Commands\Make\SeederMakeCommand($app['files'], $app['composer']);
            });
        }
    }

    public function extendCommand($singleton, $class)
    {
        $this->app->extend($singleton, function ($command, $app) use ($class) {
            return new $class($app['files']);
        });
    }
}
