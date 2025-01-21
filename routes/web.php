<?php

use App\FileConverter\UI\FileConverterController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return redirect()->route('file-converter');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/file-converter', [FileConverterController::class, 'index'])->name('file-converter');

    Route::post('/file-converter/convert-csv-to-json', [FileConverterController::class, 'convertCSVtoJSON'])->name(
        'convert-csv-to-json'
    );

    Route::get('/file-converter/download/{fileId}', [FileConverterController::class, 'download'])->name(
        'download-json'
    );
});
