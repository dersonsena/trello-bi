<?php

declare(strict_types=1);

use App\Adapter\Http\BoardTaskPerformanceReportController;
use Slim\App;
use App\Adapter\Http\BoardCycleTimeReportController;
use App\Adapter\Http\DashboardController;
use App\Shared\Adapter\Http\SlimRouteAdapter;
use App\Shared\Infra\TemplateEngineFactory;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    TemplateEngineFactory::create($app->getContainer()->get('view'));

    $app->get('/', SlimRouteAdapter::adaptAsArray(DashboardController::class))
        ->setName('dashboard');

    $app->group('/boards', function (Group $group) {
        $group->get('/{id}/reports/cycle-time', SlimRouteAdapter::adaptAsArray(BoardCycleTimeReportController::class))
            ->setName('board-cycle-time');

        $group->get('/{id}/reports/task-performance', SlimRouteAdapter::adaptAsArray(BoardTaskPerformanceReportController::class))
            ->setName('board-task-performance');
    });
};
