<?php

declare(strict_types=1);

namespace App\FileConverter\Infrastructure\Adapters\Repositories;

use App\FileConverter\Application\Ports\FileRepositoryInterface;
use App\FileConverter\Domain\Entities\File;
use Illuminate\Support\Collection;

final class FileRepository implements FileRepositoryInterface
{
    public function setStatusById(int $id, int $status): void
    {
        File::query()->where('id', $id)->update(['status' => $status]);
    }

    public function save(File $file): File
    {
        $file->save();

        return $this->findById($file->id);
    }

    public function findById(int $id): ?File
    {
        return File::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function getVisibleForUser(int $userId): Collection
    {
        return File::query()->where('user_id', $userId)
            ->orWhere('is_private', false)
            ->get();
    }

    public function getForUserByFileId(int $userId, int $fileId): ?File
    {
        return File::query()->where('user_id', $userId)
            ->where('id', $fileId)
            ->orWhere('is_private', false)
            ->first();
    }

    public function getLastUploadedForUser(int $userId): ?File
    {
        return File::query()->where('user_id', $userId)
            ->latest()
            ->first();
    }
}