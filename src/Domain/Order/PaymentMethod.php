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

    public const CREDIT_CARD = 'creditcard';
    public const DEBIT_CARD = 'debitcard';
    public const PIX = 'pix';
    public const BILLET = 'billet';

    public const ALLOWED = [
        self::CREDIT_CARD,
        self::DEBIT_CARD,
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
        string $value
    ) {
        $this->value = $value;
        $this->assertValueIsCorrect();
    }

    protected function assertValueIsCorrect(): void
    {
        DomainException::assert(in_array($this->value, self::ALLOWED), "Payment method '$this->value' is not supported, should be one of: " . implode(', ', self::ALLOWED));
    }

    public static function visa(): self
    {
        return new static(self::VISA);
    }

    public static function mastercard(): self
    {
        return new static(self::MASTERCARD);
    }

    public static function elo(): self
    {
        return new static(self::ELO);
    }

    public static function amex(): self
    {
        return new static(self::AMEX);
    }

    public static function hipercard(): self
    {
        return new static(self::HIPERCARD);
    }

    public static function discover(): self
    {
        return new static(self::DISCOVER);
    }

    public static function aura(): self
    {
        return new static(self::AURA);
    }

    public static function diners(): self
    {
        return new static(self::DINERS);
    }

    public static function jcb(): self
    {
        return new static(self::JCB);
    }

    public static function visaelectron(): self
    {
        return new static(self::VISAELECTRON);
    }

    public static function maestro(): self
    {
        return new static(self::MAESTRO);
    }

    public static function elodebit(): self
    {
        return new static(self::ELODEBIT);
    }

    public static function pix(): self
    {
        return new static(self::PIX);
    }

    public static function billet(): self
    {
        return new static(self::BILLET);
    }

    public static function creditCard(): self
    {
        return new static(self::CREDIT_CARD);
    }

    public static function debitCard(): self
    {
        return new static(self::DEBIT_CARD);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
