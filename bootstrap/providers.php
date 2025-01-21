<?php

use App\FileConverter\Infrastructure\FileConverterServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    FileConverterServiceProvider::class
];
