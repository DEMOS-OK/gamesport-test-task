<?php

declare(strict_types=1);

namespace App\FileConverter\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Column;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\PrimaryKey;
use WendellAdriel\Lift\Lift;

final class File extends Model
{
    use Lift;

    #[PrimaryKey]
    public int $id;

    #[Fillable]
    #[Column('source_title')]
    public string $sourceTitle;

    #[Fillable]
    #[Column('result_title')]
    public string $resultTitle;

    #[Fillable]
    #[Column('is_private')]
    public bool $isPrivate;

    #[Fillable]
    #[Column('user_id')]
    public int $userId;

    #[Fillable]
    #[Column('status')]
    public int $status;
}