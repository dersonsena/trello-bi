<?php

namespace App\Adapter\Http;

use App\Domain\Entity\Board;
use App\Domain\Repository\TrelloRepository;
use App\Shared\Adapter\Http\ControllerBase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class DashboardController extends ControllerBase
{
    private TrelloRepository $trelloRepository;

    public function __construct(TrelloRepository $trelloRepository)
    {
        $this->trelloRepository = $trelloRepository;
    }

    public function handle(Request $request): Response
    {
        $boards = $this->trelloRepository->getBoards();
        $boards = array_map(function(Board $board) {
            return [
                'id' => $board->getId(),
                'name' => $board->name,
                'url' => $board->url->value(),
                'lastActivity' => $board->lastActivity->format('d/m/Y H:i')
            ];
        }, $boards);

        return $this->render('dashboard/index', [
            'boards' => $boards
        ]);
    }
}