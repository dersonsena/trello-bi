<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\UrlException;
use App\Shared\Domain\ValueObjectBase;

final class Url extends ValueObjectBase
{
    private string $url;

    /**
     * @throws UrlException
     */
    public function __construct(string $url)
    {
        if (empty($url)) {
            throw UrlException::emptyUrl();
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw UrlException::invalidUrl($url, ['url' => $url]);
        }

        $this->url = $url;
    }

    public function value()
    {
        return $this->url;
    }
}
