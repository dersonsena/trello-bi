<?php

declare(strict_types=1);

return [
    'displayErrorDetails' => !APP_IS_PRODUCTION,
    'session' => [
        'name' => 'gettobi',
        'cache_expire' => 0,
        'cookie_httponly' => true,
        'cookie_secure' => APP_IS_PRODUCTION
    ],
    'trello' => [
        'baseUrl' => 'https://api.trello.com/1',
        'apiKey' => $_ENV['TRELLO_API_KEY'],
        'token' => $_ENV['TRELLO_TOKEN'],
    ],
    'twig' => [
        'templatePath' => ROOT_PATH . '/templates',
        'cachePath' => ROOT_PATH . '/var/cache'
    ]
    /*'database' => [
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'dbname' => $_ENV['DB_DATABASE'],
        'charset' => $_ENV['DB_CHARSET']
    ],*/
];