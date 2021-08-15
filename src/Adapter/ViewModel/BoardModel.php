<?php

namespace App\Adapter\ViewModel;

use App\Domain\Entity\Board;
use App\Shared\Adapter\DtoBase;

final class BoardModel extends DtoBase
{
    protected string $id;
    protected string $name;
    protected string $url;
    protected ?string $lastActivity;

    public static function adaptFrom(Board $board): self
    {
        return self::create([
            'id' => $board->getId(),
            'name' => $board->name,
            'url' => $board->url->value(),
            'lastActivity' => $board->lastActivity ? $board->lastActivity->format('d/m/Y H:i') : null
        ]);
    }
}