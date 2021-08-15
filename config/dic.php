<?php

use App\Infra\TrelloApiConnection;
use App\Shared\Adapter\Http\HttpClient;
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

$adapters = require __DIR__ . '/adapters.php';
$adapters($containerBuilder);

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

$container->set(TrelloApiConnection::class, function(Container $container) {
    $trelloConfig = $container->get('config')['trello'];
    return new TrelloApiConnection($container->get(HttpClient::class), $trelloConfig);
});