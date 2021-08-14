<?php

namespace App\Adapter\Http;

use App\Shared\Adapter\Http\ControllerBase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class DashboardController extends ControllerBase
{
    public function handle(Request $request): Response
    {
        return $this->render('dashboard/index', [
            'param1' => 'value1'
        ]);
    }
}