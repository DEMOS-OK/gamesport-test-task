<?php

declare(strict_types=1);

namespace App\FileConverter\UI;

use App\FileConverter\Application\Actions\CheckThatUserCanConvertFiles;
use App\FileConverter\Application\Actions\ConvertCSVToJSON;
use App\FileConverter\Application\Actions\DTOs\UploadedFileDTO;
use App\FileConverter\Application\Actions\GetFileForDownload;
use App\FileConverter\Application\Actions\GetFilesVisibleForUser;
use App\FileConverter\Application\Exceptions\FileNotFoundException;
use App\FileConverter\UI\Requests\ConvertCSVToJSONRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final readonly class FileConverterController extends Controller
{
    public function __construct(
        private ConvertCSVToJSON $convertCSVtoJSON,
        private GetFilesVisibleForUser $getAvailableForUserFiles,
        private GetFileForDownload $getFileForDownload,
        private CheckThatUserCanConvertFiles $checkThatUserCanConvertFiles,
    ) {
    }

    public function index(): Response
    {
        $visibleFiles = $this->getAvailableForUserFiles->run(auth()->id());
        $userCanConvertFiles = $this->checkThatUserCanConvertFiles->run(auth()->user());

        return Inertia::render('FileConverter', [
            'visibleFiles' => $visibleFiles,
            'userCanConvertFiles' => $userCanConvertFiles,
        ]);
    }

    public function convertCSVtoJSON(ConvertCSVToJSONRequest $request): RedirectResponse
    {
        $uploadedFileDTO = new UploadedFileDTO(
            $request->getFile(),
            $request->getTitle(),
            $request->isPrivate(),
            $request->user()->id,
        );

        $this->convertCSVtoJSON->run($uploadedFileDTO);

        return redirect()->back();
    }

    public function download(int $fileId): BinaryFileResponse
    {
        try {
            $file = $this->getFileForDownload->run(auth()->id(), $fileId);
        } catch (FileNotFoundException) {
            abort(404);
        }

        return response()->download(public_path('converter/json/' . $file->resultTitle));
    }
}