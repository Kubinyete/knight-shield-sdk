<?php

namespace Kubinyete\KnightShieldSdk\Domain\Locale;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use League\ISO3166\Exception\ISO3166Exception;
use League\ISO3166\Exception\OutOfBoundsException;
use League\ISO3166\ISO3166;
use Stringable;

class CountryCode implements Stringable
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
        $iso = new ISO3166();

        try {
            $info = $iso->alpha2($this->value);
        } catch (ISO3166Exception $e) {
            DomainException::assert(false, "The country code $this->value is not an valid alpha 2 code.");
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    //

    public static function br(): static
    {
        return new static('BR');
    }
}
