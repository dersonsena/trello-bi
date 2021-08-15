<?php
declare(strict_types=1);

use App\Adapter\Repository\Api\TrelloRepositoryApi;
use App\Domain\Repository\TrelloRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        TrelloRepository::class => DI\autowire(TrelloRepositoryApi::class)
    ]);
};
