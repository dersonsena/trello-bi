<?php

namespace App\Shared\Adapter\Http;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;
use Slim\App;

final class SlimRouteAdapter
{
    public const TEMPLATE_ENGINE_KEY = 'view';

    public static function create(
        string $controllerClassName,
        App $app,
        Request $request,
        Response $response,
        array $args
    ): Response {
        /** @var Controller $controller */
        $controller = new $controllerClassName;

        if (!($controller instanceof Controller)) {
            throw new RuntimeException(
                "'{$controllerClassName}' is not instance of '". Controller::class ."'"
            );
        }

        $controller->setTemplateEngine($app->getContainer()->get(self::TEMPLATE_ENGINE_KEY));
        return $controller->execute($request, $response, $args);
    }
}