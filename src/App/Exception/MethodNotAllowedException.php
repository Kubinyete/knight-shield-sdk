<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

class MethodNotAllowedException extends AppException
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "This method is not allowed for this endpoint.");
    }
}
