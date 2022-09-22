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
        ?string $description
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
        $len = strlen($this->merchant_item_id);
        DomainException::assert(is_null($this->merchant_item_id) || $len > 0 && $len <= 255, "Merchant item ID should not an empty string or exceed maximum length.");
    }

    protected function assertValidName(): void
    {
        $len = strlen($this->name);
        DomainException::assert($len > 0 && $len <= 64, "Name should not be omitted or exceed maximum length.");
    }

    protected function assertValidUnitPrice(): void
    {
        DomainException::assert($this->unit_price >= 0, "Unit price should not be omitted and should be greater or equal to zero.");
    }

    protected function assertValidQuantity(): void
    {
        DomainException::assert($this->quantity > 0, "Quantity should be greater than zero.");
    }

    protected function assertValidSku(): void
    {
        $len = strlen($this->sku);
        DomainException::assert($len > 0 && $len <= 12, "Sku should not be omitted or exceed maximum length.");
    }

    protected function assertValidDescription(): void
    {
        $len = strlen($this->description);
        DomainException::assert(is_null($this->description) || $len > 0 && $len <= 128, "Description should not be an empty string or exceed maximum length.");
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
