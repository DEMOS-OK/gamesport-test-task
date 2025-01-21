<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Actions;

use App\FileConverter\Application\Ports\FileRepositoryInterface;
use App\Models\User;

final readonly class CheckThatUserCanConvertFiles
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
    ) {
    }

    public function run(User $user): bool
    {
        if ($user->created_at->diffInDays() <= 9) {
            return false;
        }

        $latestFile = $this->fileRepository->getLastUploadedForUser($user->id);

        if ($latestFile === null) {
            return true;
        }

        // check than last file was uploaded more than 5 minutes ago
        return $latestFile->created_at->diffInMinutes() > 5;
    }
}