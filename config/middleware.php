<?php

declare(strict_types=1);

use App\Shared\Middleware\SessionMiddleware;
use App\Shared\Middleware\SlimFlashMiddleware;
use App\Shared\Middleware\TwigMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    //$app->add(SlimFlashMiddleware::class);
    $app->add(TwigMiddleware::createFromContainer($app));
    $app->addRoutingMiddleware();
    $app->addRoutingMiddleware();
};
