<?php

namespace Kubinyete\KnightShieldSdk\Domain\Auth;

use Kubinyete\KnightShieldSdk\Domain\Auth\Exception\InvalidTokenFormatException;
use Stringable;

class PlatformToken extends Token
{
    protected function assertTokenFormat(): void
    {
        $pieces = explode('.', $this->token);
        InvalidTokenFormatException::assert(count($pieces) == 3);

        $header = json_decode(base64_decode($pieces[0]), true);
        $payload = json_decode(base64_decode($pieces[1]), true);

        InvalidTokenFormatException::assert($header);
        InvalidTokenFormatException::assert($payload);
        InvalidTokenFormatException::assert($header['typ'] == 'JWT');
    }
}
