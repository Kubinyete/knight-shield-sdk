<?php

namespace Kubinyete\KnightShieldSdk\Domain\Locale;

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

    public function __toString(): string
    {
        return $this->value;
    }
}
