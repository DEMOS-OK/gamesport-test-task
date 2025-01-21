<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Actions;

use App\FileConverter\Application\Ports\FileRepositoryInterface;
use App\FileConverter\Domain\Entities\File;
use Illuminate\Support\Collection;

final readonly class GetFilesVisibleForUser
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
    ) {
    }

    /**
     * @return Collection<File>
     */
    public function run(int $userId): Collection
    {
        return $this->fileRepository->getVisibleForUser($userId);
    }
}