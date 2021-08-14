<?php
/** @var DI\Container $container */

use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('APP_ENV') or define('APP_ENV', $_ENV['APP_ENV']);
defined('APP_IS_PRODUCTION') or define('APP_IS_PRODUCTION', APP_ENV === 'production');

require_once __DIR__ . '/../config/dic.php';

// Add Twig-View Middleware
$app = AppFactory::createFromContainer($container);

// Register middleware
$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Add Error Middleware
$displayErrorDetails = $container->get('config')['displayErrorDetails'];
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);

$app->run();
