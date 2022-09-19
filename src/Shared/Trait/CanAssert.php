<?php

namespace Kubinyete\KnightShieldSdk\Shared\Trait;

trait CanAssert
{
    public static function assert(mixed $condition, ?string $message = null): void
    {
        if (!$condition) throw new self($message);
    }
}
