<?php

declare(strict_types=1);

namespace App\FileConverter\UI\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

final class ConvertCSVToJSONRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file',
            'title' => 'required|string',
            'is_private' => 'boolean',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_private' => $this->boolean('is_private'),
        ]);
    }

    public function getFile(): UploadedFile
    {
        return $this->file('file');
    }

    public function getTitle(): string
    {
        return $this->input('title');
    }

    public function isPrivate(): bool
    {
        return $this->input('is_private', false);
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'errors' => $errors
                ],
                Response::HTTP_BAD_REQUEST
            )
        );
    }
}