<?php

declare(strict_types=1);

namespace App\Adapter\Repository\Api;

use App\Domain\Entity\Board;
use App\Domain\Repository\TrelloRepository;
use App\Infra\TrelloApiConnection;

final class TrelloRepositoryApi implements TrelloRepository
{
    private TrelloApiConnection $apiConnection;

    public function __construct(TrelloApiConnection $apiConnection)
    {
        $this->apiConnection = $apiConnection;
    }

    /**
     * @inheritDoc
     */
    public function getBoards(array $params = []): array
    {
        $boards = $this->apiConnection
            ->getBoards($params)
            ->asArray();

        $collection = [];

        foreach ($boards as $board) {
            $collection[] = Board::create([
                'id' => $board['id'],
                'name' => $board['name'],
                'url' => $board['url'],
                'lastActivity' => $board['dateLastActivity']
            ]);
        }

        return $collection;
    }
}