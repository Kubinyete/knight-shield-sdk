<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\App\Response;
use Kubinyete\KnightShieldSdk\Shared\Trait\CanAssert;

class ResponseRuntimeException extends ResponseException
{
    use CanAssert;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "An runtime exception occured while parsing the response body.");
    }
}
