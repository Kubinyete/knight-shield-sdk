<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\App\Response;

class ResponseRuntimeException extends ResponseException
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "An runtime exception occured while parsing the response body.");
    }
}
