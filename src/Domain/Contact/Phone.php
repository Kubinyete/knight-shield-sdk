<?php

namespace Kubinyete\KnightShieldSdk\Domain\Contact;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Stringable;

class Phone implements Stringable
{
    private const DEFAULT_COUNTRY = 'BR';

    protected string $value;

    public function __construct(
        string $value,
    ) {
        $this->value = $this->assertValueIsCorrect($value);
    }

    protected function parseNumber(string $value): PhoneNumber
    {
        $lib = PhoneNumberUtil::getInstance();

        try {
            $parsedNumber = $lib->parse($value, self::DEFAULT_COUNTRY);
        } catch (NumberParseException $e) {
        }

        DomainException::assert($parsedNumber, "Value is not a valid phone number.");
        DomainException::assert($lib->isValidNumber($parsedNumber), "Value is not a valid phone number.");

        return $parsedNumber;
    }

    protected function assertValueIsCorrect(string $value): string
    {
        return PhoneNumberUtil::getInstance()->format($this->parseNumber($value), PhoneNumberFormat::E164);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
