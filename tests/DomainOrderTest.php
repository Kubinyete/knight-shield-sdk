<?php

namespace Tests;

use DateInterval;
use DateTime;
use Kubinyete\KnightShieldSdk\App\ApiClient;
use Kubinyete\KnightShieldSdk\Domain\Contact\Email;
use Kubinyete\KnightShieldSdk\Domain\Contact\MobilePhone;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Locale\CurrencyCode;
use Kubinyete\KnightShieldSdk\Domain\Order\PaymentMethod;
use Kubinyete\KnightShieldSdk\Domain\Locale\StateCode;
use Kubinyete\KnightShieldSdk\Domain\Order\Card;
use Kubinyete\KnightShieldSdk\Domain\Order\Customer;
use Kubinyete\KnightShieldSdk\Domain\Order\Factor;
use Kubinyete\KnightShieldSdk\Domain\Order\Item;
use Kubinyete\KnightShieldSdk\Domain\Order\Order;
use Kubinyete\KnightShieldSdk\Domain\Order\Payment;
use Kubinyete\KnightShieldSdk\Domain\Address\BillingAddress;
use Kubinyete\KnightShieldSdk\Domain\Auth\ApiToken;
use Kubinyete\KnightShieldSdk\Domain\Person\Document;
use Kubinyete\KnightShieldSdk\Domain\Person\DocumentType;
use Kubinyete\KnightShieldSdk\Domain\Person\Gender;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class DomainOrderTest extends TestCase
{
    public function testOrderCannotHaveNegativeAmount()
    {
        $this->expectException(DomainException::class);
        $birthdate = (new DateTime())->sub(new DateInterval('P18Y'));

        $order = new Order(
            time(),
            -100,
            1,
            CurrencyCode::brl(),
            new Customer(
                'Vitor Kubinyete',
                new Document(CountryCode::br(), '863.722.120-30', DocumentType::taxId()),
                Gender::masculine(),
                $birthdate,
                new Email('sample@localhost.test'),
                new MobilePhone('+5518998234532'),
                null
            ),
            new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '123C', 'Centro', null, 'Presidente Prudente', '19360000'),
            null,
            new Factor('192.168.1.100', null),
            [
                new Item(null, 'ITEM A', 10.00, 1, 'ITEMA', null),
                new Item(null, 'ITEM B', 20.00, 1, 'ITEMB', null),
            ],
            [
                new Payment(PaymentMethod::mastercard(), 30.00, new Card('VITOR K', '5244103872380925', '03', '2023'))
            ]
        );
    }

    public function testOrderCannotHaveZeroAmount()
    {
        $this->expectException(DomainException::class);
        $birthdate = (new DateTime())->sub(new DateInterval('P18Y'));

        $order = new Order(
            time(),
            0,
            1,
            CurrencyCode::brl(),
            new Customer(
                'Vitor Kubinyete',
                new Document(CountryCode::br(), '863.722.120-30', DocumentType::taxId()),
                Gender::masculine(),
                $birthdate,
                new Email('sample@localhost.test'),
                new MobilePhone('+5518998234532'),
                null
            ),
            new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '123C', 'Centro', null, 'Presidente Prudente', '19360000'),
            null,
            new Factor('192.168.1.100', null),
            [
                new Item(null, 'ITEM A', 10.00, 1, 'ITEMA', null),
                new Item(null, 'ITEM B', 20.00, 1, 'ITEMB', null),
            ],
            [
                new Payment(PaymentMethod::mastercard(), 30.00, new Card('VITOR K', '5244103872380925', '03', '2023'))
            ]
        );
    }

    public function testCanCreateValidOrder()
    {
        $id = time();
        $birthdate = (new DateTime())->sub(new DateInterval('P18Y'));

        $order = new Order(
            $id,
            30,
            1,
            CurrencyCode::brl(),
            new Customer(
                'Vitor Kubinyete',
                new Document(CountryCode::br(), '863.722.120-30', DocumentType::taxId()),
                Gender::masculine(),
                $birthdate,
                new Email('sample@localhost.test'),
                new MobilePhone('+5518998234532'),
                null
            ),
            new BillingAddress(CountryCode::br(), new StateCode('SP'), 'Av. Teste', '123C', 'Centro', null, 'Presidente Prudente', '19360000'),
            null,
            new Factor('192.168.1.100', null),
            [
                new Item(null, 'ITEM A', 10.00, 1, 'ITEMA', null),
                new Item(null, 'ITEM B', 20.00, 1, 'ITEMB', null),
            ],
            [
                new Payment(PaymentMethod::mastercard(), 30.00, new Card('VITOR K', '5244103872380925', '03', '2023'))
            ]
        );

        $this->assertEquals([
            "merchant_order_id" => "$id",
            "amount" => 30.0,
            "currency" => "BRL",
            "customer" => [
                "full_name" => "Vitor Kubinyete",
                "document" => [
                    "nationality" => "BR",
                    "number" => "863.722.120-30",
                    "type" => "T",
                ],
                "gender" => "M",
                "birth_date" => $birthdate->format('Y-m-d'),
                "email" => "sample@localhost.test",
                "mobile_phone" => "+5518998234532",
                "phone" => null,
            ],
            "billing_address" => [
                "country" => "BR",
                "state" => "SP",
                "street" => "Av. Teste",
                "number" => "123C",
                "district" => "Centro",
                "complement" => null,
                "city" => "Presidente Prudente",
                "zipcode" => "19360000",
            ],
            "shipping_address" => null,
            "cart" => [
                "items" => [
                    [
                        "merchant_item_id" => null,
                        "name" => "ITEM A",
                        "unit_price" => 10.0,
                        "quantity" => 1,
                        "sku" => "ITEMA",
                        "description" => null,
                    ],
                    [
                        "merchant_item_id" => null,
                        "name" => "ITEM B",
                        "unit_price" => 20.0,
                        "quantity" => 1,
                        "sku" => "ITEMB",
                        "description" => null,
                    ]
                ]
            ],
            "factors" => [
                "with_ip_address" => "192.168.1.100",
                "with_fingerprint" => null,
                "is_vip_customer" => false,
                "days_since_first_purchase" => 0,
            ],
            "payments" => [
                [
                    "method" => "mastercard",
                    "amount" => 30.0,
                    "card" => [
                        "holder" => "VITOR K",
                        "number" => "5244103872380925",
                        "expiry_month" => "03",
                        "expiry_year" => "2023",
                    ],
                ]
            ],
            "metadata" => null,
        ], $order->jsonSerialize());
    }
}
