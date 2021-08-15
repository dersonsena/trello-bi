<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Shared\Domain\EntityBase;
use App\Shared\Domain\ValueObjects\Url;
use DateTimeImmutable;
use DateTimeInterface;

final class Card extends EntityBase
{
    protected int $code;
    protected Board $board;
    protected string $title;
    protected string $description;
    protected int $position;
    protected Url $url;
    protected DateTimeInterface $lastActivity;

    public static function create(array $values): EntityBase
    {
        $values['url'] = new Url($values['url']);
        $values['lastActivity'] = new DateTimeImmutable($values['lastActivity']);
        return parent::create($values);
    }
}