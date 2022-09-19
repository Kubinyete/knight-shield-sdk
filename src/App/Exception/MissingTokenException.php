<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\Shared\Trait\CanAssert;

class MissingTokenException extends AppException
{
    use CanAssert;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "This action requires an access token, but is missing from client.");
    }
}
