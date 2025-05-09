<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Totocsa\TranslationsGUI\Http\Controllers\TranslationsController;
use Totocsa\DatabaseTranslationLocally\Models\Translationoriginal;
use Totocsa\DatabaseTranslationLocally\Models\Translationvariant;
use Totocsa\DatabaseTranslationLocally\Models\Locale;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('translations/export', function (Request $request) {
    $t0 = (new Translationvariant())->getTable();
    $t1 = (new Translationoriginal())->getTable();
    $t2 = (new Locale())->getTable();

    $translations = DB::table($t0)
        ->select([
            "$t1.category as category",
            "$t1.subtitle as original",
            "$t2.configname as language",
            "$t0.subtitle as translation"
        ])
        ->leftJoin("{$t1}", "$t0.{$t1}_id", '=', "$t1.id")
        ->leftJoin("{$t2}", "$t0.{$t2}_id", '=', "$t2.id")
        ->get();

    return response()->json($translations); // 🚀 Inertia NEM fogja ezt feldolgozni!
})->withoutMiddleware([\Inertia\Middleware::class])->name('api.translations.export');

Route::post('translations/import', [TranslationsController::class, 'import'])
    ->withoutMiddleware([\Inertia\Middleware::class])->name('api.translations.import');
