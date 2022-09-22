<?php

namespace Kubinyete\KnightShieldSdk\Shared\Exception;

abstract class Exception extends \Exception
{
    public static function assert(mixed $condition, ?string $message = null): void
    {
        if (!$condition) throw new static($message);
    }
}
