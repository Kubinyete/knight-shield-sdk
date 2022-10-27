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
        ?string $shipping_provider
    ) {
        parent::__construct($country, $state, $street, $number, $district, $complement, $city, $zipcode);

        $this->shipping_cost = $shipping_cost;
        $this->shipping_tracking_number = $shipping_tracking_number ? substr(trim($shipping_tracking_number), 0, 32) : $shipping_tracking_number;
        $this->shipping_comment = $shipping_comment ? substr(trim($shipping_comment), 0, 256) : $shipping_comment;
        $this->shipping_provider = $shipping_provider ? substr(trim($shipping_provider), 0, 256) : $shipping_provider;

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
        $len = strlen($this->shipping_tracking_number);
        DomainException::assert(is_null($this->shipping_tracking_number) || $len > 0 && $len <= 32, "Shipping tracking number cannot be an empty string or exceed maximum length.");
    }

    protected function assertValidShippingComment(): void
    {
        $len = strlen($this->shipping_comment);
        DomainException::assert(is_null($this->shipping_comment) || $len > 0 && $len <= 256, "Shipping comment cannot be an empty string or exceed maximum length.");
    }

    protected function assertValidShippingProvider(): void
    {
        $len = strlen($this->shipping_provider);
        DomainException::assert(is_null($this->shipping_provider) || $len > 0 && $len <= 64, "Shipping provider cannot be an empty string or exceed maximum length.");
    }
}
