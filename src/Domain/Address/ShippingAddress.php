<?php

namespace Kubinyete\KnightShieldSdk\Domain\Address;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Locale\StateCode;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class ShippingAddress extends Address
{
    protected ?float $shipping_cost;
    protected ?string $shipping_tracking_number;
    protected ?string $shipping_comment;
    protected ?string $shipping_provider;

    public function __construct(
        CountryCode $country,
        StateCode $state,
        string $street,
        string $number,
        string $district,
        ?string $complement,
        string $city,
        string $zipcode,
        ?float $shipping_cost,
        ?string $shipping_tracking_number,
        ?string $shipping_comment,
        ?string $shipping_provider,
    ) {
        parent::__construct($country, $state, $street, $number, $district, $complement, $city, $zipcode);

        $this->shipping_cost = $shipping_cost;
        $this->shipping_tracking_number = $shipping_tracking_number;
        $this->shipping_comment = $shipping_comment;
        $this->shipping_provider = $shipping_provider;

        $this->assertValidShippingCost();
        $this->assertValidShippingTrackingNumber();
        $this->assertValidShippingComment();
        $this->assertValidShippingProvider();
    }

    protected function assertValidShippingCost(): void
    {
        DomainException::assert(is_null($this->shipping_cost) || $this->shipping_cost >= 0, "Shipping cost can be null or greater than 0.");
    }

    protected function assertValidShippingTrackingNumber(): void
    {
        DomainException::assert(is_null($this->shipping_tracking_number) || strlen($this->shipping_tracking_number), "Shipping tracking number cannot be an empty string.");
    }

    protected function assertValidShippingComment(): void
    {
        DomainException::assert(is_null($this->shipping_comment) || strlen($this->shipping_comment), "Shipping comment cannot be an empty string.");
    }

    protected function assertValidShippingProvider(): void
    {
        DomainException::assert(is_null($this->shipping_provider) || strlen($this->shipping_provider), "Shipping provider cannot be an empty string.");
    }
}
