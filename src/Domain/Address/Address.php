<?php

namespace Kubinyete\KnightShieldSdk\Domain\Address;

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
        string $zipcode
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
        $len = strlen($this->street);
        DomainException::assert($len > 0 && $len <= 128, "Street name should not be omitted or exceed max length.");
    }

    protected function assertValidNumber(): void
    {
        $len = strlen($this->number);
        DomainException::assert($len > 0 && $len <= 16, "Address number should not be omitted or exceed max length.");
        DomainException::assert(preg_match('/^[a-zA-Z0-9]+$/', $this->number), "Address number should be alphanumeric.");
    }

    protected function assertValidDistrict(): void
    {
        $len = strlen($this->district);
        DomainException::assert($len > 0 && $len <= 64, "District name should not be omitted or exceed max length.");
    }

    protected function assertValidComplement(): void
    {
        $len = strlen($this->complement);
        DomainException::assert(is_null($this->complement) || $len > 0 && $len <= 64, "Address complement should not be omitted or exceed max length.");
    }

    protected function assertValidCity(): void
    {
        $len = strlen($this->city);
        DomainException::assert($len > 0 && $len <= 64, "City name should not be omitted or exceed max length.");
    }

    protected function assertValidZipcode(): void
    {
        $len = strlen($this->zipcode);
        DomainException::assert($len == 8, "Zipcode should not be omitted and must have 8 digits.");
        DomainException::assert(preg_match('/^[0-9]+$/', $this->zipcode), "Zipcode should contain only digits.");
    }

    public function jsonSerialize(): mixed
    {
        return [
            'country' => (string)$this->country,
            'state' => (string)$this->state,
            'street' => $this->street,
            'number' => $this->number,
            'district' => $this->district,
            'complement' => $this->complement,
            'city' => $this->city,
            'zipcode' => $this->zipcode,
        ];
    }
}
