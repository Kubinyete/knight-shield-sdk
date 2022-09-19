<?php

namespace Kubinyete\KnightShieldSdk\Domain\Contact;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class Email implements Stringable
{
    protected string $value;

    public function __construct(
        string $value,
    ) {
        $this->value = $value;
        $this->assertValueIsCorrect();
    }

    protected function assertValueIsCorrect(): void
    {
        DomainException::assert(filter_var($this->value, FILTER_VALIDATE_EMAIL) !== false, "Value is not a valid email address.");
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
