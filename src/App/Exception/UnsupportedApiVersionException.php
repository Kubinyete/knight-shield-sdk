<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

class UnsupportedApiVersionException extends AppException
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "Specified API version is currently not supported yet.");
    }
}
