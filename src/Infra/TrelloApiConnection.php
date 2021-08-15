<?php

declare(strict_types=1);

namespace App\Infra;

use App\Shared\Adapter\Http\HttpClient;
use Psr\Http\Message\ResponseInterface as Response;

final class TrelloApiConnection
{
    private HttpClient $httpClient;
    private array $config;
    private Response $response;

    public function __construct(HttpClient $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function getBoards(array $params = []): self
    {
        $this->response = $this->httpClient->get(
            $this->buildUrl('/members/me/boards'),
            $this->buildQueryParams($params)
        );

        return $this;
    }

    public function getBoard($boardId): self
    {
        $this->response = $this->httpClient->get(
            $this->buildUrl(sprintf("/boards/%s", $boardId)),
            $this->buildQueryParams()
        );

        return $this;
    }

    public function getBoardsCard($boardId): self
    {
        $this->response = $this->httpClient->get(
            $this->buildUrl(sprintf("/boards/%s/cards", $boardId)),
            $this->buildQueryParams()
        );

        return $this;
    }

    public function getCardActions($cardId, array $params = []): self
    {
        $this->response = $this->httpClient->get(
            $this->buildUrl(sprintf("/cards/%s/actions", $cardId)),
            $this->buildQueryParams($params)
        );

        return $this;
    }

    public function asArray(): array
    {
        return json_decode((string)$this->response->getBody(), true);
    }

    private function buildUrl(string $url): string
    {
        return $this->config['baseUrl'] . $url;
    }

    private function buildQueryParams(array $params = []): array
    {
        return ['query' => array_merge($params, [
            'key' => $this->config['apiKey'],
            'token' => $this->config['token']
        ])];
    }
}