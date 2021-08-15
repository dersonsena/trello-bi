<?php

namespace App\Shared\Adapter\Http;

final class SlimRouteAdapter
{
    public const TEMPLATE_ENGINE_KEY = 'view';

    public static function adaptAsArray(string $controllerName): array
    {
        return [$controllerName, 'execute'];
    }

    public static function adaptAsString(string $controllerName): string
    {
        return $controllerName;
    }
}