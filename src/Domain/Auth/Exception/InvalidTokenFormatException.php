<?php

namespace Kubinyete\KnightShieldSdk\Domain\Auth\Exception;

use Kubinyete\KnightShieldSdk\Shared\Trait\CanAssert;

final class InvalidTokenFormatException extends AuthException
{
    use CanAssert;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "Provided token format is incorrect or missing.");
    }
}
