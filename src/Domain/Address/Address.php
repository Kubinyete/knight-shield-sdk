<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Locale\StateCode;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

abstract class Address implements JsonSerializable
{
    protected CountryCode $country;
    protected StateCode $state;
    protected string $street;
    protected string $number;
    protected string $district;
    protected ?string $complement;
    protected string $city;
    protected string $zipcode;

    public function __construct(
        CountryCode $country,
        StateCode $state,
        string $street,
        string $number,
        string $district,
        ?string $complement,
        string $city,
        string $zipcode,
    ) {
        $this->country = $country;
        $this->state = $state;
        $this->street = $street;
        $this->number = $number;
        $this->district = $district;
        $this->complement = $complement;
        $this->city = $city;
        $this->zipcode = $zipcode;

        $this->assertValidStreet();
        $this->assertValidNumber();
        $this->assertValidDistrict();
        $this->assertValidComplement();
        $this->assertValidCity();
        $this->assertValidZipcode();
    }

    protected function assertValidStreet(): void
    {
        DomainException::assert(strlen($this->street), "Street name should not be omitted.");
    }

    protected function assertValidNumber(): void
    {
        DomainException::assert(strlen($this->number), "Address number should not be omitted.");
        DomainException::assert(preg_match('/^[a-zA-Z0-9]+$/', $this->number), "Address number should be alphanumeric.");
    }

    protected function assertValidDistrict(): void
    {
        DomainException::assert(strlen($this->district), "District should not be omitted.");
    }

    protected function assertValidComplement(): void
    {
        DomainException::assert(is_null($this->complement) || strlen($this->complement), "District should not be omitted.");
    }

    protected function assertValidCity(): void
    {
        DomainException::assert(strlen($this->city), "City name should not be omitted.");
    }

    protected function assertValidZipcode(): void
    {
        DomainException::assert(preg_match('/^[0-9]+$/', $this->zipcode), "Zipcode should contain only digits.");
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
