<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\Shared\Trait\CanAssert;

class UnsupportedApiVersionException extends AppException
{
    use CanAssert;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "Specified API version is currently not supported yet.");
    }
}
