<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Board;
use App\Domain\Entity\Card;

interface BoardRepository
{
    /**
     * @return Board[]
     */
    public function getBoards(array $params = []): array;

    /**
     * @param int|string $boardId
     * @return Board
     */
    public function getBoardById($boardId): ?Board;

    public function getCardActivities(Board $board): array;
}