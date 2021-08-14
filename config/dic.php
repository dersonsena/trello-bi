<?php

use App\Adapter\Trello\TrelloApi;
use App\Shared\Adapter\Contracts\HttpClient;
use App\Shared\Infra\TwigAdapter;
use DI\Container;
use DI\ContainerBuilder;
use Odan\Session\SessionInterface;
use Slim\Flash\Messages;

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
    $twigConfig = $container->get('config')['twig'];
    $flash = $container->get(Messages::class);
    $session = $container->get(SessionInterface::class);
    return new TwigAdapter($twigConfig, $flash, $session);
});

$container->set('trelloApi', function(Container $container) {
    $trelloConfig = $container->get('config')['trello'];
    return new TrelloApi($container->get(HttpClient::class), $trelloConfig);
});