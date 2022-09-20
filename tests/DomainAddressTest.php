<?php

namespace Tests;

use Kubinyete\KnightShieldSdk\Domain\Auth\ApiToken;
use Kubinyete\KnightShieldSdk\Domain\Address\BillingAddress;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Locale\StateCode;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class DomainAddressTest extends TestCase
{
    public function testAddressShouldRequireEssentialValues()
    {
        $this->expectException(DomainException::class);
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '', 'Centro', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '123C', '', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '123C', 'Centro', null, '', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '123C', 'Centro', null, 'Presidente Prudente', '');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '123C', 'Centro', null, 'Presidente Prudente', '19360000');
    }

    public function testAddressNumberShouldNotAcceptSymbols()
    {
        $this->expectException(DomainException::class);
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C-', 'Centro', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '!@#', 'Centro', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '.', 'Centro', null, 'Presidente Prudente', '19360000');
    }

    public function testAddressNumberShouldAcceptAlphanumeric()
    {
        $this->expectException(DomainException::class);
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '993', 'Centro', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '124AF', 'Centro', null, 'Presidente Prudente', '19360000');
    }

    public function testAddressZipcodeShouldNotAcceptNonDigits()
    {
        $this->expectException(DomainException::class);
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', 'AF');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', 'EFAW3573');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', '@!%12');
    }

    public function testAddressZipcodeShouldAcceptDigits()
    {
        $this->expectException(DomainException::class);
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', '12312333');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', '19360000');
        $address = new BillingAddress(CountryCode::br(), new StateCode('SP'), '', '123C', 'Centro', null, 'Presidente Prudente', '10293910');
    }
}
