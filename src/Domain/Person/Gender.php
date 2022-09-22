<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class Gender implements Stringable
{
    public const MASCULINE = 'M';
    public const FEMININE = 'F';
    public const ALLOWED = [self::MASCULINE, self::FEMININE];

    protected string $value;

    public function __construct(
        string $value,
    ) {
        $this->value = strtoupper($value);
        $this->assertValueIsCorrect();
    }

    public static function masculine(): self
    {
        return new static(self::MASCULINE);
    }

    public static function feminine(): self
    {
        return new static(self::FEMININE);
    }

    protected function assertValueIsCorrect(): void
    {
        DomainException::assert(in_array($this->value, self::ALLOWED, true), "Gender can only be one of: " . implode(', ', self::ALLOWED));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
