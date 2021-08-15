<?php

namespace App\Adapter\Http;

use App\Adapter\ViewModel\BoardModel;
use App\Domain\Entity\Board;
use App\Domain\Repository\BoardRepository;
use App\Shared\Adapter\Http\ControllerBase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class DashboardController extends ControllerBase
{
    private BoardRepository $trelloRepository;

    public function __construct(BoardRepository $trelloRepository)
    {
        $this->trelloRepository = $trelloRepository;
    }

    public function handle(Request $request): Response
    {
        $boards = $this->trelloRepository->getBoards();
        $boards = array_map(function(Board $board) {
            return BoardModel::adaptFrom($board);
        }, $boards);

        return $this->render('dashboard/index', [
            'boards' => $boards
        ]);
    }
}