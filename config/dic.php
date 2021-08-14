<?php

use App\Api\Trello\TrelloApi;
use App\Shared\Adapter\Contracts\HttpClient;
use DI\Container;
use DI\ContainerBuilder;
use Odan\Session\SessionInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;

$containerBuilder = new ContainerBuilder();

if (APP_IS_PRODUCTION) {
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($containerBuilder);

$repositories = require __DIR__ . '/repositories.php';
$repositories($containerBuilder);

$container = $containerBuilder->build();

$container->set('config', function() {
    return require __DIR__ . DS . 'config.php';
});

$container->set('view', function () use ($container) {
    $twig = Twig::create(
        __DIR__ . '/../templates',
        ['cache' => APP_IS_PRODUCTION ? __DIR__ . '/../var/cache' : false]
    );

    $flash = $container->get(Messages::class);
    $twig->getEnvironment()->addGlobal('session', $container->get(SessionInterface::class));
    $twig->getEnvironment()->addGlobal('flash', $flash);
    $twig->getEnvironment()->addGlobal('sessionCookieName', 'gettobi');
    return $twig;
});

$container->set('trelloApi', function(Container $container) {
    $trelloConfig = $container->get('config')['trello'];
    return new TrelloApi($container->get(HttpClient::class), $trelloConfig);
});