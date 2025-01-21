<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Actions;

use App\FileConverter\Application\Actions\DTOs\UploadedFileDTO;
use App\FileConverter\Application\Jobs\ConvertCSVToJSONJob;
use App\FileConverter\Application\Ports\FileRepositoryInterface;
use App\FileConverter\Domain\Entities\File;
use App\FileConverter\Domain\Enums\FileStatusEnum;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Throwable;

final readonly class ConvertCSVToJSON
{
    use DispatchesJobs;

    public function __construct(
        private FileRepositoryInterface $fileRepository,
    ) {
    }

    public function run(UploadedFileDTO $fileDTO): void
    {
        $file = $this->storeToDatabase($fileDTO);

        try {
            $this->storeToDisk($fileDTO, $file->sourceTitle);
            $this->dispatch(new ConvertCSVToJSONJob($file));
        } catch (Throwable) {
            $file->status = FileStatusEnum::FAILED->value;
            $this->fileRepository->save($file);
            return;
        }
    }

    private function storeToDatabase(UploadedFileDTO $fileDTO): File
    {
        $file = new File();

        $randomString = bin2hex(random_bytes(16));
        $file->sourceTitle = "{$fileDTO->title}_{$randomString}.csv";

        $file->resultTitle = "{$fileDTO->title}_{$randomString}.json";
        $file->userId = $fileDTO->userId;
        $file->status = FileStatusEnum::PENDING->value;
        $file->isPrivate = $fileDTO->isPrivate;

        return $this->fileRepository->save($file);
    }

    private function storeToDisk(UploadedFileDTO $fileDTO, string $fileName): string
    {
        return $fileDTO->file->storeAs('converter/csv', $fileName, ['disk' => 'uploads']);
    }
}