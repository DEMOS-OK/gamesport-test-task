<?php

declare(strict_types=1);

namespace App\FileConverter\Infrastructure;

use App\FileConverter\Application\Ports\FileConverterInterface;
use App\FileConverter\Application\Ports\FileRepositoryInterface;
use App\FileConverter\Infrastructure\Adapters\FileConverter;
use App\FileConverter\Infrastructure\Adapters\Repositories\FileRepository;
use Illuminate\Support\ServiceProvider;

final class FileConverterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            FileConverterInterface::class,
            FileConverter::class
        );
        $this->app->bind(
            FileRepositoryInterface::class,
            FileRepository::class
        );
    }
}