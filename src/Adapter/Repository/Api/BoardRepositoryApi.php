<?php

declare(strict_types=1);

namespace App\Adapter\Repository\Api;

use App\Domain\Entity\Board;
use App\Domain\Entity\Card;
use App\Domain\Repository\BoardRepository;
use App\Infra\TrelloApiConnection;
use GuzzleHttp\Exception\RequestException;

final class BoardRepositoryApi implements BoardRepository
{
    private TrelloApiConnection $apiConnection;

    public function __construct(TrelloApiConnection $apiConnection)
    {
        $this->apiConnection = $apiConnection;
    }

    public function getBoards(array $params = []): array
    {
        $collection = [];

        try {
            $boards = $this->apiConnection
                ->getBoards($params)
                ->asArray();

            foreach ($boards as $board) {
                $collection[] = Board::create([
                    'id' => $board['id'],
                    'name' => $board['name'],
                    'url' => $board['url'],
                    'lastActivity' => $board['dateLastActivity']
                ]);
            }

            return $collection;
        } catch (RequestException $e) {
            return $collection;
        }
    }

    public function getBoardById($boardId): ?Board
    {
        try {
            $board = $this->apiConnection
                ->getBoard($boardId)
                ->asArray();

            return Board::create([
                'id' => $board['id'],
                'name' => $board['name'],
                'url' => $board['url'],
            ]);

        } catch (RequestException $e) {
            return null;
        }
    }

    public function getCardActivities(Board $board): array
    {
        $activities = [];

        try {
            $cards = $this->apiConnection
                ->getBoardsCard($board->id)
                ->asArray();

            $activities = $this->apiConnection
                ->getCardActions($board->id, ['filter' => 'updateCard:idList'])
                ->asArray();

            /**
             * [
             *   '{cardId}' => [
             *      'code' => 123
             *      'title' => 'card title',
             *      'position' => 2,
             *      'activities' => [
             *        '{listId}' => [
             *          'entryDatetime' => new DatetimeImmutable(),
             *          'exitDatetime' => new DatetimeImmutable()
             *        ]
             *      ]
             *   ]
             * ]
             */

            foreach ($cards as $card) {
                $activities[] = Card::create([
                    'id' => $card['id'],
                    'board' => $board,
                    'code' => (int)$card['idShort'],
                    'title' => $card['name'],
                    'description' => $card['desc'],
                    'position' => (int)$card['pos'],
                    'url' => $card['url'],
                    'lastActivity' => $card['dateLastActivity']
                ]);
            }

            return $activities;
        } catch (RequestException $e) {
            return $collection;
        }
    }
}