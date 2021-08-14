<?php

declare(strict_types=1);

use App\Shared\Adapter\Contracts\HttpClient;
use App\Shared\Adapter\Http\TemplateEngine;
use App\Shared\Infra\GuzzleHttpClient;
use App\Shared\Infra\TwigAdapter;
use DI\ContainerBuilder;
use Odan\Session\Middleware\SessionMiddleware;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        // Adapters
        HttpClient::class => GuzzleHttpClient::class,
        TemplateEngine::class => TwigAdapter::class,

        // Interface Implementations
        SessionInterface::class => function (ContainerInterface $c) {
            $sessionParams = $c->get('config')['session'];
            $session = new PhpSession();
            $session->setOptions($sessionParams);
            return $session;
        },
        SessionMiddleware::class => function (ContainerInterface $c) {
            return new SessionMiddleware($c->get(SessionInterface::class));
        },
        Messages::class => function (ContainerInterface $c) {
            $storage = [];
            return new Messages($storage);
        },
    ]);
};
