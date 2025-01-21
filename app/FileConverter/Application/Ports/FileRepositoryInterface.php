<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Ports;

use App\FileConverter\Domain\Entities\File;
use Illuminate\Support\Collection;

interface FileRepositoryInterface
{
    public function save(File $file): File;

    public function findById(int $id): ?File;

    public function setStatusById(int $id, int $status): void;

    /**
     * @return Collection<File>
     */
    public function getVisibleForUser(int $userId): Collection;

    public function getLastUploadedForUser(int $userId): ?File;

    public function getForUserByFileId(int $userId, int $fileId): ?File;
}