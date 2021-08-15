<?php
declare(strict_types=1);

use App\Shared\Adapter\Http\HttpClient;
use App\Shared\Adapter\Http\TemplateEngine;
use App\Shared\Infra\GuzzleHttpClient;
use App\Shared\Infra\TwigAdapter;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        HttpClient::class => DI\autowire(GuzzleHttpClient::class),
        TemplateEngine::class => DI\autowire(TwigAdapter::class)
    ]);
};