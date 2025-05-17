<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Totocsa\UsersGUI\Http\Controllers\UserController;
use Totocsa\DatabaseTranslationLocally\Http\Controllers\LocalesController;
use Totocsa\TranslationsGUI\Http\Controllers\TranslationsController;
use Totocsa\DatabaseTranslationLocally\Http\Middleware\SetLocale;
use Totocsa\DatabaseTranslationLocally\Http\Middleware\LoadTranslations;
use Totocsa\AuthorizationGUI\Http\Controllers\RoleController;
use Totocsa\AuthorizationGUI\Http\Controllers\PermissionController;
use Totocsa\AuthorizationGUI\Http\Controllers\RoleHasPermissionsController;
use Totocsa\AuthorizationGUI\Http\Controllers\ModelHasPermissionsController;
use Totocsa\AuthorizationGUI\Http\Controllers\ModelHasRolesController;
use Totocsa\Icseusd\Http\Controllers\GenericController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', SetLocale::class, LoadTranslations::class]
], function () {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('/');

    require_once __DIR__ . '/fortify.php';

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/administration', function () {
            return Inertia::render('Administration');
        })->name('administration');

        Route::middleware(['auth', 'administrator'])->group(function () {
            Route::post('users/saveEditable', [UserController::class, 'saveEditable'])->name('users.saveEditable');
            Route::resource('users', UserController::class);

            Route::resource('locales', LocalesController::class);
        });

        Route::middleware(['auth', 'administratorOrTranslator'])->group(function () {
            Route::get('translations/loaderrefresh', [TranslationsController::class, 'loaderrefresh'])->name('translations.loaderrefresh');
            Route::post('translations/save', [TranslationsController::class, 'save'])->name('translations.save');
            Route::post('translations/saveEditable', [TranslationsController::class, 'saveEditable'])->name('translations.saveEditable');
            Route::resource('translations', TranslationsController::class);
        });

        Route::middleware(['auth', 'developer'])->group(function () {
            Route::get('icseusd/generics/{configName}', [GenericController::class, 'index'])->name('icseusd.generics.index');

            // Roles
            Route::post('authorization/roles/saveEditable', [RoleController::class, 'saveEditable'])->name('authorization.roles.saveEditable');
            Route::resource('authorization/roles', RoleController::class, [
                'only' => ['index', 'store', 'update', 'destroy'],
                'as' => 'authorization'
            ]);

            // Permissions
            Route::get('authorization/permissions/refreshRoutes', [PermissionController::class, 'refreshRoutes'])
                ->name('authorization.permissions.refreshRoutes');

            Route::post('authorization/permissions/assign', [PermissionController::class, 'assign'])
                ->name('authorization.permissions.assign');

            Route::delete('authorization/permissions/revoke/{routeName}', [PermissionController::class, 'revoke'])
                ->name('authorization.permissions.revoke');

            Route::resource('authorization/permissions', PermissionController::class, [
                'only' => ['index'],
                'as' => 'authorization'
            ]);

            // Role has permissions
            Route::get('authorization/rolehaspermissions/rolePermissions/{role}', [RoleHasPermissionsController::class, 'rolePermissions'])
                ->name('authorization.rolehaspermissions.rolePermissions');

            Route::delete('authorization/rolehaspermissions/revoke/{roleId}/{permissionName}', [RoleHasPermissionsController::class, 'revoke'])
                ->name('authorization.rolehaspermissions.revoke');

            Route::resource('authorization/rolehaspermissions', RoleHasPermissionsController::class, [
                'only' => ['index', 'store'],
                'as' => 'authorization'
            ]);

            // Model has permissions
            Route::get('authorization/modelhaspermissions/modelsByClassName', [ModelHasPermissionsController::class, 'modelsByClassName'])
                ->name('authorization.modelhaspermissions.modelsByClassName');

            Route::get('authorization/modelhaspermissions/permissions/{configName}/{modelId}', [ModelHasPermissionsController::class, 'permissions'])
                ->name('authorization.modelhaspermissions.permissions');

            Route::delete('authorization/modelhaspermissions/permissions/{configName}/{modelId}/{permissionId}', [ModelHasPermissionsController::class, 'destroy'])
                ->name('authorization.modelhaspermissions.destroy');

            Route::resource('authorization/modelhaspermissions', ModelHasPermissionsController::class, [
                'only' => ['index', 'store'],
                'as' => 'authorization'
            ]);

            // Model has roles
            Route::get('authorization/modelhasroles/modelsByClassName', [ModelHasRolesController::class, 'modelsByClassName'])
                ->name('authorization.modelhasroles.modelsByClassName');

            Route::get('authorization/modelhasroles/roles/{configName}/{modelId}', [ModelHasRolesController::class, 'roles'])
                ->name('authorization.modelhasroles.roles');

            Route::delete('authorization/modelhasroles/roles/{configName}/{modelId}/{roleId}', [ModelHasrolesController::class, 'destroy'])
                ->name('authorization.modelhasroles.destroy');

            Route::resource('authorization/modelhasroles', ModelHasRolesController::class, [
                'only' => ['index', 'store'],
                'as' => 'authorization'
            ]);

            // Authorization kezdőoldal a roles oldal.
            Route::get('authorization', function () {
                return redirect('authorization/roles');
            })->name('authorization.index');
        });

        require_once __DIR__ . '/jetstream-inertia.php';
    });
});
