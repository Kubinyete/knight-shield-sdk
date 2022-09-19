<?php

namespace Kubinyete\KnightShieldSdk\Domain\Auth;

use Kubinyete\KnightShieldSdk\Domain\Auth\Exception\InvalidTokenFormatException;
use Stringable;

abstract class Token implements Stringable
{
    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->assertTokenFormat();
    }

    protected abstract function assertTokenFormat(): void;

    public function __toString(): string
    {
        return $this->token;
    }
}
