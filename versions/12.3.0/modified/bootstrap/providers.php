<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    Totocsa\DatabaseTranslationLocally\Providers\TranslationServiceProvider::class,
    Totocsa\DatabaseTranslationLocally\Providers\ValidationServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
];
