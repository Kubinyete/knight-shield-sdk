<?php

namespace Kubinyete\KnightShieldSdk\Domain\Order;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Locale\CurrencyCode;
use Kubinyete\KnightShieldSdk\Domain\Person\BillingAddress;
use Kubinyete\KnightShieldSdk\Domain\Person\ShippingAddress;

class Order implements JsonSerializable
{
    protected ?string $merchant_order_id;
    protected float $amount;
    protected CurrencyCode $currency;
    protected Customer $customer;
    protected BillingAddress $billing_address;
    protected ShippingAddress $shipping_address;
    protected Cart $cart;
    protected Factor $factors;
    protected array $payments = [];
    protected array $metadata = [];

    public function __construct(
        ?string $merchant_order_id,
        float $amount,
        CurrencyCode $currency,
        Customer $customer,
        BillingAddress $billing_address,
        ?ShippingAddress $shipping_address,
        Factor $factors,
        array $items = [],
        array $payments = [],
        array $metadata = [],
    ) {
        $this->merchant_order_id = $merchant_order_id;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->customer = $customer;
        $this->billing_address = $billing_address;
        $this->shipping_address = $shipping_address;
        $this->factors = $factors;
        $this->cart = new Cart();
        $this->addItems($items);
        $this->addPayments($payments);
        $this->metadata = $metadata;
    }

    public function addItem(Item $item): void
    {
        $this->cart->addItem($item);
    }

    public function addItems(array $items): void
    {
        $this->cart->addItems($items);
    }

    public function addPayment(Payment $payment): void
    {
        $this->payments[] = $payment;
    }

    public function addPayments(array $payments): void
    {
        foreach ($payments as $payment) {
            $this->addPayment($payment);
        }
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
