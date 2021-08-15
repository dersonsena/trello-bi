<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Shared\Domain\Contracts\Entity;
use App\Shared\Domain\EntityBase;
use App\Shared\Domain\ValueObjects\Url;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @property-read string $name
 * @property-read Url $url
 * @property-read DateTimeInterface $lastActivity
 */
final class Board extends EntityBase
{
    protected string $name;
    protected Url $url;
    protected DateTimeInterface $lastActivity;

    public static function create(array $values): Entity
    {
        $values['url'] = new Url($values['url']);
        $values['lastActivity'] = new DateTimeImmutable($values['lastActivity']);
        return parent::create($values);
    }
}