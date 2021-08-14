<?php

declare(strict_types=1);

use App\Adapter\Http\DashboardController;
use App\Shared\Adapter\Http\SlimRouteAdapter;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, array $args) use ($app) {
        return SlimRouteAdapter::create(DashboardController::class, $app, $request, $response, $args);
    })->setName('dashboard');

    $app->group('/boards', function (Group $group) {
        $group->get('/{id}', function (Request $request, Response $response) {
            $response->getBody()->write('Board Details');
            return $response;
        })->setName('board-details');

        $group->get('/{id}/cards', function (Request $request, Response $response) {
            $response->getBody()->write('Board Cards');
            return $response;
        })->setName('board-cards');

        $group->get('/{id}/cycle-time', function (Request $request, Response $response) {
            $response->getBody()->write('Cycle time Report');
            return $response;
        })->setName('cycle-time-report');

        $group->get('/{id}/task-hour', function (Request $request, Response $response) {
            $response->getBody()->write('Task hour Report');
            return $response;
        })->setName('task-hour-report');
    });

    $app->group('/cards', function (Group $group) {
        $group->get('/{id}', function (Request $request, Response $response) {
            $response->getBody()->write('Card Details');
            return $response;
        })->setName('card-details');
    });
};
