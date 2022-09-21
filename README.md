# KnightShield SDK for PHP

KnightShield is a standalone antifraud system that takes information about your orders and analyses them to provide
recommendations about it's risk factors.

### Requirements

1. PHP 7.0+

### Usage

You can start right away by importing our ApiClient, you will need our authorization token to proceed.

```php
use DateInterval;
use DateTime;
use Kubinyete\KnightShieldSdk\App\ApiClient;
use Kubinyete\KnightShieldSdk\Domain\Auth\ApiToken;
use Kubinyete\KnightShieldSdk\Domain\Address\BillingAddress;
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

$client = ApiClient(new ApiToken('YOUR_API_TOKEN_HERE'));

try {
    $order = new Order(
        $id = time(),
        30,
        CurrencyCode::brl(),
        new Customer(
            'Client Full Name',
            new Document(CountryCode::br(), '863.722.120-30', DocumentType::taxId()),
            Gender::masculine(),
            $birthdate = (new DateTime())->sub(new DateInterval('P18Y'));,
            new Email('approve@domain.test'),
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
            new Payment(PaymentMethod::mastercard(), 30.00, new Card('CARD HOLDER NAME', '5244103872380925', '03', '2023'))
        ]
    );

    $response = $client->createOrder($order);
    $responseData = $response->getBody()
    $lastRecommendation = $response->getResponsePath('last_recommendation');

    var_dump($responseData, $lastRecommendation);
} catch (\Kubinyete\KnightShieldSdk\Shared\Exception\DomainException $e) {
    exit("Cannot validate order information: " . $e->getMessage());
} catch (\Kubinyete\KnightShieldSdk\App\Exception\ResponseRuntimeException $e) {
    exit("An error ocurred while parsing: " . $e->getMessage());
}
```