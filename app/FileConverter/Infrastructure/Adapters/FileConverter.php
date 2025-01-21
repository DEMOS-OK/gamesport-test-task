<?php

declare(strict_types=1);

namespace App\FileConverter\Infrastructure\Adapters;

use App\FileConverter\Application\Ports\FileConverterInterface;
use JsonException;

final class FileConverter implements FileConverterInterface
{
    /**
     * @throws JsonException
     */
    public function convertCSVtoJSON(string $csvFilePath, string $jsonFilePath): void
    {
        $csvFile = fopen($csvFilePath, 'rb');
        $jsonFile = fopen($jsonFilePath, 'wb');

        $header = fgetcsv($csvFile);
        $rows = [];

        while ($row = fgetcsv($csvFile)) {
            $rows[] = array_combine($header, $row);
        }

        fwrite($jsonFile, json_encode($rows, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        fclose($csvFile);
        fclose($jsonFile);
    }
}