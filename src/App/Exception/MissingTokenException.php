<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

class MissingTokenException extends AppException
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "This action requires an access token, but is missing from client.");
    }
}
