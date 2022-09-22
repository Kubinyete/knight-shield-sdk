<?php

namespace Kubinyete\KnightShieldSdk\Domain\Auth\Exception;

final class InvalidTokenFormatException extends AuthException
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "Provided token format is incorrect or missing.");
    }
}
