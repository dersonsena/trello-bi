<?php

declare(strict_types=1);

namespace App\Adapter\Http;

use App\Adapter\ViewModel\BoardModel;
use App\Domain\Repository\BoardRepository;
use App\Shared\Adapter\Http\ControllerBase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class BoardCycleTimeReportController extends ControllerBase
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

        $wipQueue = [
            '60cfc26616b81d6aa67d48ba', // Doing
            '60d090a514d07d46431fc516', // Ready to Homolog
            '60cfc38eb4102424c16c0112', // Homologating
            '60d12e7dee5f6330141b71e3', // Ready to Deploy
            '60cfc3997d46b93e9f1b516a' // Done
        ];

        return $this->render('boards/cycle-time', [
            'board' => BoardModel::adaptFrom($board)
        ]);
    }
}