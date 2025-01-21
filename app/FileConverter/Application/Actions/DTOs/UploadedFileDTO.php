<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Actions\DTOs;

use Illuminate\Http\UploadedFile;

final readonly class UploadedFileDTO
{
    public function __construct(
        public UploadedFile $file,
        public string $title,
        public bool $isPrivate,
        public int $userId,
    ) {
    }
}