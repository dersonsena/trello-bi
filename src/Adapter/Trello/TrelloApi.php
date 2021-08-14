<?php

declare(strict_types=1);

namespace App\Adapter\Trello;

use App\Shared\Adapter\Contracts\HttpClient;

final class TrelloApi
{
    private HttpClient $httpClient;
    private array $config;

    public function __construct(HttpClient $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }
}