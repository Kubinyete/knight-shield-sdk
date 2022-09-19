<?php

namespace Kubinyete\KnightShieldSdk\Domain\Order;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Locale\PaymentMethod;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class Payment implements JsonSerializable
{
    protected PaymentMethod $method;
    protected float $amount;
    protected ?Card $card;

    public function __construct(
        PaymentMethod $method,
        float $amount,
        ?Card $card,
    ) {
        $this->method = $method;
        $this->amount = $amount;
        $this->card = $card;

        $this->assertValidAmount();
    }

    protected function assertValidAmount(): void
    {
        DomainException::assert($this->amount >= 0, "Payment amound should be greater or equal to zero.");
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
