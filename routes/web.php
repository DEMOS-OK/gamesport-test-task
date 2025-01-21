<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', static function () {
    return redirect()->route('json-tree-generator');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/json-tree-generator', static function () {
        return Inertia::render('JsonTreeGenerator');
    })->name('json-tree-generator');
});
