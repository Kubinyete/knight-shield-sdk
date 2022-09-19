<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\Shared\Trait\CanAssert;

class MethodNotAllowedException extends AppException
{
    use CanAssert;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "This method is not allowed for this endpoint.");
    }
}
