<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Totocsa\DatabaseTranslationLocally\Helpers\LocalesHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LocalesHelper::refreshLocalesByConfig();

        Inertia::share('userRoles', function () {
            $allRoles = array_fill_keys(Role::pluck('name')->toArray(), false);
            $allRoles['Guest'] = !auth()->check();

            if (!$allRoles['Guest']) {
                $userRoles = auth()->user()->getRoleNames()->toArray();
                foreach ($userRoles as $v) {
                    $allRoles[$v] = true;
                }
            }

            return $allRoles;
        });
    }
}
