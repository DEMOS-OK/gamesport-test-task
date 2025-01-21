<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Actions;

use App\FileConverter\Application\Exceptions\FileNotFoundException;
use App\FileConverter\Application\Ports\FileRepositoryInterface;
use App\FileConverter\Domain\Entities\File;

final readonly class GetFileForDownload
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
    ) {
    }

    /**
     * @throws FileNotFoundException
     */
    public function run(int $userId, int $fileId): File
    {
        $file = $this->fileRepository->getForUserByFileId($userId, $fileId);
        if (!$file) {
            throw new FileNotFoundException('File not found');
        }

        return $file;
    }
}