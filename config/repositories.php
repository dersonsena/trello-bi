<?php
declare(strict_types=1);

use App\Adapter\Repository\Api\BoardRepositoryApi;
use App\Domain\Repository\BoardRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BoardRepository::class => DI\autowire(BoardRepositoryApi::class)
    ]);
};
