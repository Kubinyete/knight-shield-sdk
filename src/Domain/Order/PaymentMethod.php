<?php

namespace Kubinyete\KnightShieldSdk\Domain\Order;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class PaymentMethod implements Stringable
{
    protected string $value;

    public const VISA = 'visa';
    public const MASTERCARD = 'mastercard';
    public const ELO = 'elo';
    public const AMEX = 'amex';
    public const HIPERCARD = 'hipercard';
    public const DISCOVER = 'discover';
    public const AURA = 'aura';
    public const DINERS = 'diners';
    public const JCB = 'jcb';
    public const VISAELECTRON = 'visaelectron';
    public const MAESTRO = 'maestro';
    public const ELODEBIT = 'elodebit';
    public const PIX = 'pix';
    public const BILLET = 'billet';

    public const ALLOWED = [
        self::VISA,
        self::MASTERCARD,
        self::ELO,
        self::AMEX,
        self::HIPERCARD,
        self::DISCOVER,
        self::AURA,
        self::DINERS,
        self::JCB,
        self::VISAELECTRON,
        self::MAESTRO,
        self::ELODEBIT,
        self::PIX,
        self::BILLET,
    ];

    public function __construct(
        string $value,
    ) {
        $this->value = $value;
        $this->assertValueIsCorrect();
    }

    protected function assertValueIsCorrect(): void
    {
        DomainException::assert(in_array($this->value, self::ALLOWED), "Payment method '$this->value' is not supported, should be one of: " . implode(', ', self::ALLOWED));
    }

    public static function visa(): static
    {
        return new static(self::VISA);
    }

    public static function mastercard(): static
    {
        return new static(self::MASTERCARD);
    }

    public static function elo(): static
    {
        return new static(self::ELO);
    }

    public static function amex(): static
    {
        return new static(self::AMEX);
    }

    public static function hipercard(): static
    {
        return new static(self::HIPERCARD);
    }

    public static function discover(): static
    {
        return new static(self::DISCOVER);
    }

    public static function aura(): static
    {
        return new static(self::AURA);
    }

    public static function diners(): static
    {
        return new static(self::DINERS);
    }

    public static function jcb(): static
    {
        return new static(self::JCB);
    }

    public static function visaelectron(): static
    {
        return new static(self::VISAELECTRON);
    }

    public static function maestro(): static
    {
        return new static(self::MAESTRO);
    }

    public static function elodebit(): static
    {
        return new static(self::ELODEBIT);
    }

    public static function pix(): static
    {
        return new static(self::PIX);
    }

    public static function billet(): static
    {
        return new static(self::BILLET);
    }


    public function __toString(): string
    {
        return $this->value;
    }
}
