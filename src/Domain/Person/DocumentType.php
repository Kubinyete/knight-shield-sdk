<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person;

use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class DocumentType implements Stringable
{
    public const TAX_ID = 'T';
    public const ID_CARD = 'I';
    public const PASSPORT = 'P';
    public const ALLOWED = [self::TAX_ID, self::ID_CARD, self::PASSPORT];

    protected string $value;

    public function __construct(
        string $value,
    ) {
        $this->value = $value;
        $this->assertValueIsCorrect();
    }

    protected function assertValueIsCorrect(): void
    {
        DomainException::assert(in_array($this->value, self::ALLOWED, true), "Document type can only be one of: " . implode(', ', self::ALLOWED));
    }

    public static function taxId(): self
    {
        return new static(self::TAX_ID);
    }

    public static function idCard(): self
    {
        return new static(self::ID_CARD);
    }

    public static function passport(): self
    {
        return new static(self::PASSPORT);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
