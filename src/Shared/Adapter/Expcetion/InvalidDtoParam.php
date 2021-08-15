<?php

namespace App\Shared\Adapter\Exception;

use Exception;
use Throwable;

final class InvalidDtoParam extends Exception
{
    private array $details;

    private function __construct(
        $message = "",
        $details = [],
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->details = $details;
    }

    public static function dynamicParam(string $className, string $property)
    {
        return new self(sprintf(
            "It couldn't construct DTO '%s' because the property '%s' doesn't exist",
            $className, $property
        ), [
            'className' => $className,
            'property' => $property,
        ]);
    }

    public static function readonlyProperty(string $className, string $property, $value)
    {
        return new self(sprintf(
            "You cannot change the property '%s' of the DTO class '%s' because it is read-only.",
            $property, $className
        ), [
            'className' => $className,
            'property' => $property,
            'value' => $value
        ]);
    }
}