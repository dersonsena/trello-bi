<?php

declare(strict_types=1);

namespace App\Adapter\Http;

use App\Adapter\ViewModel\BoardModel;
use App\Domain\Repository\BoardRepository;
use App\Shared\Adapter\Http\ControllerBase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class BoardTaskPerformanceReportController extends ControllerBase
{
    private BoardRepository $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function handle(Request $request): Response
    {
        $board = $this->boardRepository->getBoardById($this->args['id']);
        //$cardActivities = $this->boardRepository->getCardActivities($board);

        return $this->render('boards/task-performance', [
            'board' => BoardModel::adaptFrom($board)
        ]);
    }
}