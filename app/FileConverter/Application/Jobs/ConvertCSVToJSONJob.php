<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Jobs;

use App\FileConverter\Application\Ports\FileConverterInterface;
use App\FileConverter\Application\Ports\FileRepositoryInterface;
use App\FileConverter\Domain\Entities\File;
use App\FileConverter\Domain\Enums\FileStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

final class ConvertCSVToJSONJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly File $file,
    ) {
        $this->delay = 5;
    }

    public function handle(FileConverterInterface $fileConverter, FileRepositoryInterface $fileRepository): void
    {
        try {
            $fileRepository->setStatusById($this->file->id, FileStatusEnum::PROCESSING->value);

            $fileConverter->convertCSVtoJSON(
                public_path("converter/csv/{$this->file->sourceTitle}"),
                public_path("converter/json/{$this->file->resultTitle}"),
            );

            $fileRepository->setStatusById($this->file->id, FileStatusEnum::FINISHED->value);
        } catch (Throwable) {
            $fileRepository->setStatusById($this->file->id, FileStatusEnum::FAILED->value);
        }
    }
}