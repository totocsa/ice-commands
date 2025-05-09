<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'setLocale' => \Totocsa\DatabaseTranslationLocally\Http\Middleware\SetLocale::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \Totocsa\DatabaseTranslationLocally\Http\Middleware\SetLocale::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $middlewareAliases = [
        /**** OTHER MIDDLEWARE ****/
        'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ];

    protected $middleware = [
        \Totocsa\DatabaseTranslationLocally\Http\Middleware\LoadTranslations::class,
    ];
}
