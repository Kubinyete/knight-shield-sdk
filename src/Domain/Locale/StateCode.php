<?php

namespace Kubinyete\KnightShieldSdk\Domain\Locale;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class StateCode implements Stringable
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
        DomainException::assert(preg_match('/^[A-Z]{2}$/', $this->value) !== false, "The state code $this->value is not an valid alpha 2 code.");
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
