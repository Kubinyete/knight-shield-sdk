<?php

namespace Kubinyete\KnightShieldSdk\Domain\Address;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Locale\StateCode;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class BillingAddress extends Address
{
    public function __construct(
        CountryCode $country,
        StateCode $state,
        ?string $street,
        ?string $number,
        ?string $district,
        ?string $complement,
        ?string $city,
        ?string $zipcode
    ) {
        parent::__construct($country, $state, $street, $number, $district, $complement, $city, $zipcode);
    }
}
