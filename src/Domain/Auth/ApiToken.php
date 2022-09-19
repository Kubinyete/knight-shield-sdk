<?php

namespace Kubinyete\KnightShieldSdk\Domain\Auth;

use Kubinyete\KnightShieldSdk\Domain\Auth\Exception\InvalidTokenFormatException;
use Stringable;

class ApiToken extends Token
{
    protected function assertTokenFormat(): void
    {
        InvalidTokenFormatException::assert(preg_match('/^[0-9]+\|[a-zA-Z0-9]{40}$/', $this->token));
    }
}
