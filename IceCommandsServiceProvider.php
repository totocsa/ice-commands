<?php

namespace Totocsa\IceCommands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Totocsa\MigrationHelper\MigrationHelper;


class IceCommandsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Ha van konfigurációs fájl, azt itt töltheted be
        //$this->mergeConfigFrom(__DIR__.'/../config/destroy-confirm-modal.php', 'destroy-confirm-modal');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Totocsa\IceCommands\Console\Commands\CreateUser::class,
                \Totocsa\IceCommands\Console\Commands\DirPerms::class,
                \Totocsa\IceCommands\Console\Commands\Install::class,
                \Totocsa\IceCommands\Console\Commands\SendEmail::class,
                \Totocsa\IceCommands\Console\Commands\SetEnv::class,
                \Totocsa\IceCommands\Console\Commands\SetUserRoles::class,
            ]);
        }

        $groupsBase = 'ice-commands';
        $groups = "$groupsBase-migrations";

        $paths = MigrationHelper::stubsToMigrations($groups, __DIR__ . '/database/migrations/');
        $this->publishes($paths, $groups);
    }
}
