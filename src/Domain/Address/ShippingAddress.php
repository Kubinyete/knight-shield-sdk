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
        ?string $street,
        ?string $number,
        ?string $district,
        ?string $complement,
        ?string $city,
        ?string $zipcode,
        ?float $shipping_cost,
        ?string $shipping_tracking_number,
        ?string $shipping_comment,
        ?string $shipping_provider
    ) {
        parent::__construct($country, $state, $street, $number, $district, $complement, $city, $zipcode);

        $this->shipping_cost = $shipping_cost;
        $this->shipping_tracking_number = $shipping_tracking_number ? mb_strcut(trim($shipping_tracking_number), 0, 32) : $shipping_tracking_number;
        $this->shipping_comment = $shipping_comment ? mb_strcut(trim($shipping_comment), 0, 256) : $shipping_comment;
        $this->shipping_provider = $shipping_provider ? mb_strcut(trim($shipping_provider), 0, 256) : $shipping_provider;

        $this->assertValidShippingCost();
    }

    protected function assertValidShippingCost(): void
    {
        DomainException::assert(is_null($this->shipping_cost) || $this->shipping_cost >= 0, "Shipping cost can be null or greater or equal to 0.");
    }
}
