<?php

namespace Totocsa\IceCommands\Traits;

trait Install
{
    protected $installCommands = [
        [
            'info' => 'Set directories permissions.',
            'commands' => [
                ['php', 'artisan', 'ice:dir-perms', '--dir=storage'],
                ['php', 'artisan', 'ice:dir-perms', '--dir=bootstrap' . DIRECTORY_SEPARATOR . 'cache'],
            ],
        ],
        [
            'info' => 'Migration.',
            'commands' => [
                ['php', 'artisan', 'migrate', '--no-interaction', '--force'],
            ],
        ],
        [
            'info' => 'Install laravel/fortify.',
            'commands' => [
                ['composer', 'require', 'laravel/fortify'],
            ],
        ],
        [
            'info' => 'Install laravel/jetstream.',
            'commands' => [
                ['composer', 'require', 'laravel/jetstream'],
            ],
        ],
        [
            'info' => 'Install Jetstream.',
            'commands' => [
                ['yes', '|', 'php', 'artisan', 'jetstream:install', 'inertia'],
            ],
        ],
        [
            'info' => 'Publish language.',
            'commands' => [
                ['php', 'artisan', 'lang:publish'],
            ],
        ],
        [
            'info' => 'Install mcamara/laravel-localization.',
            'commands' => [
                ['composer', 'require', 'mcamara/laravel-localization'],
                ['php', 'artisan', 'vendor:publish', '--provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"'],
                ['php', '-r', "\"copy('vendor" . DIRECTORY_SEPARATOR . 'laravel' . DIRECTORY_SEPARATOR . 'fortify' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . "routes.php', 'routes" . DIRECTORY_SEPARATOR . "fortify.php');\""],
                ['php', '-r', "\"copy('vendor" . DIRECTORY_SEPARATOR . 'laravel' . DIRECTORY_SEPARATOR . 'jetstream' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . "inertia.php', 'routes" . DIRECTORY_SEPARATOR . "jetstream-inertia.php');\""],
            ],
        ],
        [
            'info' => 'Install spatie/laravel-permission.',
            'commands' => [
                ['composer', 'require', 'spatie/laravel-permission'],
                ['php', 'artisan', 'vendor:publish', '--provider="Spatie\Permission\PermissionServiceProvider"'],
            ],
        ],
        [
            'info' => 'Install npm packages.',
            'commands' => [
                ['npm', 'install', '-D', '@babel/core', '@babel/preset-env'],
                ['npm', 'install', '-D', '@babel/eslint-parser'],
                ['npm', 'install', '-D', 'eslint', 'eslint-plugin-vue', 'vue-eslint-parser'],
                ['npm', 'install', '-D', 'pinia'],
                ['npm', 'install', '-D', '@heroicons/vue'],
                ['npm', 'install', '-D', '@headlessui/vue@latest'],
                ['npm', 'install', '-D', 'flag-icons'],
                ['npm', 'install', '-D', 'exceljs'],
                ['npm', 'install', '-D', 'file-saver'],
                ['npm', 'install', '-D', 'zod'],
                ['npm', 'install', '-D', 'focus-trap-vue'],
            ],
        ],
        [
            'info' => 'Install IconAsync Vue component.',
            'commands' => [
                ['git', 'clone', 'https://github.com/bealejd/blog-async-icons.git', 'resources' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'Components' . DIRECTORY_SEPARATOR . 'bealejd' . DIRECTORY_SEPARATOR . 'blog-async-icons'],
            ],
        ],
        [
            'info' => 'Install button animate.',
            'commands' => [
                ['composer', 'require', 'totocsa/laravel-animate-success-form'],
                ['php', 'artisan', 'vendor:publish', '--tag=laravel-animate-success-form'],
            ],
        ],
        [
            'info' => 'Install axios interceptors.',
            'commands' => [
                ['composer', 'require', 'totocsa/laravel-axios-interceptors'],
                ['php', 'artisan', 'vendor:publish', '--tag=laravel-axios-interceptors'],
            ],
        ],
        [
            'info' => 'Install unique multiple validator.',
            'commands' => [
                ['composer', 'require', 'totocsa/laravel-unique-multiple'],
            ],
        ],
        [
            'info' => 'Install migration helper.',
            'commands' => [
                ['composer', 'require', 'totocsa/laravel-migration-helper'],
                ['php', 'artisan', 'vendor:publish', '--tag=laravel-migration-helper-migrations'],
            ],
        ],
        [
            'info' => 'Install modal li fo.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-modal-li-fo'],
                //['php', 'artisan', 'vendor:publish', '--tag=ice-modal-li-fo'],
            ],
        ],
        [
            'info' => 'Install database translation locally.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-database-translation-locally'],
                ['php', 'artisan', 'vendor:publish', '--tag=ice-database-translation-locally-migrations'],
                //['php', 'artisan', 'vendor:publish', '--tag=ice-database-translation-locally-resources', '--force'],
            ],
        ],
        [
            'info' => 'Install icseusd.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-icseusd'],
                //['php', 'artisan', 'vendor:publish', '--tag=ice-icseusd-resources'],
            ],
        ],
        [
            'info' => 'Install translations GUI.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-translations-gui'],
                //['php', 'artisan', 'vendor:publish', '--tag=ice-translations-gui-resources'],
            ],
        ],
        [
            'info' => 'Install users GUI.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-users-gui'],
                ['php', 'artisan', 'vendor:publish', '--tag=ice-users-gui-migrations'],
            ],
        ],
        [
            'info' => 'Install authorization GUI.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-authorization-gui'],
                ['php', 'artisan', 'vendor:publish', '--tag=ice-authorization-gui-migrations'],
            ],
        ],
        [
            'info' => 'Install tailwindcss helper.',
            'commands' => [
                ['composer', 'require', 'totocsa/laravel-tailwindcss-helper'],
            ],
        ],
        [
            'info' => 'Install Ice icons.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-icons'],
                ['php', 'artisan', 'vendor:publish', '--tag=ice-icons'],
            ],
        ],
        [
            'info' => 'Install Ice seeders.',
            'commands' => [
                ['composer', 'require', 'totocsa/ice-seeders'],
            ],
        ],
        [
            'info' => 'Install HasLabels.',
            'commands' => [
                ['composer', 'require', 'totocsa/laravel-has-labels'],
            ],
        ],
    ];

    protected $lastCommands = [
        [
            'info' => 'Last commands.',
            'commands' => [
                ['npm', 'install'],
                ['npm', 'run', 'build'],
                ['php', 'artisan', 'optimize:clear'],
                ['php', 'artisan', 'migrate'],
            ],
        ],
    ];
}
