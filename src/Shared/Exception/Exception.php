<?php

namespace Kubinyete\KnightShieldSdk\Shared\Exception;

abstract class Exception extends \Exception
{
    public static function assert($condition, ?string $message = null): void
    {
        if (!$condition) throw new static($message);
    }
}
