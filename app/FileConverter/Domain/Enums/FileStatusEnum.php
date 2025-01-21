<?php

namespace App\FileConverter\Domain\Enums;

enum FileStatusEnum: int
{
    case PENDING = 1;
    case PROCESSING = 2;
    case FINISHED = 3;
    case FAILED = 4;
}
