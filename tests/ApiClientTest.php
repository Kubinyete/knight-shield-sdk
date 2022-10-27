<?php

namespace Tests;

use DateInterval;
use DateTime;
use Kubinyete\KnightShieldSdk\App\Client;
use Kubinyete\KnightShieldSdk\App\ApiClient;
use Kubinyete\KnightShieldSdk\Domain\Address\BillingAddress;
use Kubinyete\KnightShieldSdk\Domain\Auth\ApiToken;
use Kubinyete\KnightShieldSdk\Domain\Contact\Email;
use Kubinyete\KnightShieldSdk\Domain\Contact\MobilePhone;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Locale\CurrencyCode;
use Kubinyete\KnightShieldSdk\Domain\Locale\StateCode;
use Kubinyete\KnightShieldSdk\Domain\Order\Card;
use Kubinyete\KnightShieldSdk\Domain\Order\Customer;
use Kubinyete\KnightShieldSdk\Domain\Order\Factor;
use Kubinyete\KnightShieldSdk\Domain\Order\Item;
use Kubinyete\KnightShieldSdk\Domain\Order\Order;
use Kubinyete\KnightShieldSdk\Domain\Order\Payment;
use Kubinyete\KnightShieldSdk\Domain\Order\PaymentMethod;
use Kubinyete\KnightShieldSdk\Domain\Person\Document;
use Kubinyete\KnightShieldSdk\Domain\Person\DocumentType;
use Kubinyete\KnightShieldSdk\Domain\Person\Gender;

class ApiClientTest extends TestCase
{
    protected function makeTestClient(): ApiClient
    {
        return new ApiClient(
            new ApiToken(getenv('API_TOKEN')),
            ApiClient::SUPPORTED_API_VERSION_LATEST,
            ApiClient::DEFAULT_TIMEOUT_SECONDS,
            getenv('API_HOST'),
            getenv('API_PROTOCOL'),
            getenv('API_PORT')
        );
    }

    public function testCanCallEndpointWithAuthenticatedToken()
    {
        $client = $this->makeTestClient();
        $response = $client->getMe();
        $this->assertEquals(200, $response->getStatus());
    }

    public function testCanSubmitOrder()
    {
        $id = time();
        $birthdate = (new DateTime())->sub(new DateInterval('P18Y'));

        $order = new Order(
            $id,
            30,
            1,
            CurrencyCode::brl(),
            new Customer(
                null,
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

        $response = $this->makeTestClient()->createOrder($order);
        $this->assertEquals(201, $response->getStatus());
        $uuid = $response->getResponsePath('id');

        return $uuid;
    }

    /**
     * @depends testCanSubmitOrder
     */
    public function testCanGetOrder(string $uuid)
    {
        $response = $this->makeTestClient()->getOrder($uuid);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEquals($response->getResponsePath('id'), $uuid);
    }

    /**
     * @depends testCanSubmitOrder
     */
    public function testCanListOrders(string $uuid)
    {
        $response = $this->makeTestClient()->getOrders();
        $this->assertEquals(200, $response->getStatus());

        $data = $response->getResponsePath('data');
        $this->assertIsArray($data);
        $this->assertGreaterThan(1, count($data));
        $this->assertEquals($data[0]['id'], $uuid);
    }
}
