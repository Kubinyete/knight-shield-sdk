<?php

namespace Kubinyete\KnightShieldSdk\Domain\Order;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class Item implements JsonSerializable
{
    protected ?string $merchant_item_id;
    protected string $name;
    protected float $unit_price;
    protected int $quantity;
    protected string $sku;
    protected ?string $description;

    public function __construct(
        ?string $merchant_item_id,
        string $name,
        float $unit_price,
        int $quantity,
        string $sku,
        ?string $description,
    ) {
        $this->merchant_item_id = $merchant_item_id;
        $this->name = $name;
        $this->unit_price = $unit_price;
        $this->quantity = $quantity;
        $this->sku = $sku;
        $this->description = $description;

        $this->assertValidMerchantItemId();
        $this->assertValidName();
        $this->assertValidUnitPrice();
        $this->assertValidQuantity();
        $this->assertValidSku();
        $this->assertValidDescription();
    }

    protected function assertValidMerchantItemId(): void
    {
        DomainException::assert(is_null($this->merchant_item_id) || strlen($this->merchant_item_id), "Merchant item ID should not an empty string.");
    }

    protected function assertValidName(): void
    {
        DomainException::assert(strlen($this->name), "Name should not be omitted.");
    }

    protected function assertValidUnitPrice(): void
    {
        DomainException::assert($this->unit_price >= 0, "Unit_price should not be omitted and should be greater or equal to zero.");
    }

    protected function assertValidQuantity(): void
    {
        DomainException::assert($this->quantity > 0, "Quantity should be greater than zero.");
    }

    protected function assertValidSku(): void
    {
        DomainException::assert(strlen($this->sku), "Sku should not be omitted.");
    }

    protected function assertValidDescription(): void
    {
        DomainException::assert(is_null($this->description) || strlen($this->description), "Description should not be an empty string.");
    }


    public function jsonSerialize(): mixed
    {
        return [
            'merchant_item_id' => $this->merchant_item_id,
            'name' => $this->name,
            'unit_price' => $this->unit_price,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'description' => $this->description,
        ];
    }
}
