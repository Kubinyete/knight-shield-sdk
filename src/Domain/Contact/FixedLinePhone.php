<?php

namespace Kubinyete\KnightShieldSdk\Domain\Contact;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use Stringable;

class FixedLinePhone extends Phone
{
    protected function assertValueIsCorrect(string $value): string
    {
        $lib = PhoneNumberUtil::getInstance();
        $number = $this->parseNumber($value);

        DomainException::assert($lib->getNumberType($number) == PhoneNumberType::FIXED_LINE);
        return $lib->format($number, PhoneNumberFormat::E164);
    }
}
