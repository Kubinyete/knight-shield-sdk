<?php

namespace Kubinyete\KnightShieldSdk\Domain\Locale;

use Alcohol\ISO4217;
use DomainException as GlobalDomainException;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use League\ISO3166\Exception\ISO3166Exception;
use Stringable;

class CurrencyCode implements Stringable
{
    protected string $value;

    public function __construct(
        string $value
    ) {
        $this->value = $value;
        $this->assertValueIsCorrect();
    }

    protected function assertValueIsCorrect(): void
    {
        $iso = new ISO4217();

        try {
            $info = $iso->getByAlpha3($this->value);
        } catch (GlobalDomainException $e) {
            DomainException::assert(false, "The currency code $this->value is not an valid alpha 3 code.");
        }
    }

    public static function brl(): self
    {
        return new static('BRL');
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
