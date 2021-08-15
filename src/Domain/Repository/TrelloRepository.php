<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Board;

interface TrelloRepository
{
    /**
     * @return Board[]
     */
    public function getBoards(array $params = []): array;
}