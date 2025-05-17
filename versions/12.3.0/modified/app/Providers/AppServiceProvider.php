<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Totocsa\DatabaseTranslationLocally\Models\Locale;

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
        $this->setSupportedLocales();

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

    protected function setSupportedLocales()
    {
        $enableds = Locale::where('enabled', true)->orderBy('name')->get();
        if ($enableds->count() < 1) {
            Locale::where('configname', 'en')->update(['enabled' => true]);
            $enableds = Locale::where('enabled', true)->orderBy('name')->get();
        }

        $supportedLocales = [];
        $keys = ['name', 'script', 'native', 'regional', 'flag'];
        foreach ($enableds as $m) {
            $supportedLocales[$m->configname] = array_intersect_key($m->getAttributes(), array_flip($keys));
        }

        Config::set('laravellocalization.supportedLocales', $supportedLocales);
    }
}
