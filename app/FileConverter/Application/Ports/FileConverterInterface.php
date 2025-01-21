<?php

declare(strict_types=1);

namespace App\FileConverter\Application\Ports;

interface FileConverterInterface
{
    public function convertCSVtoJSON(string $csvFilePath, string $jsonFilePath): void;
}