<?php

namespace Kubinyete\KnightShieldSdk\Domain\Order;

use DateTime;
use DateInterval;
use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Contact\Email;
use Kubinyete\KnightShieldSdk\Domain\Person\Gender;
use Kubinyete\KnightShieldSdk\Domain\Person\Document;
use Kubinyete\KnightShieldSdk\Domain\Contact\MobilePhone;
use Kubinyete\KnightShieldSdk\Domain\Contact\FixedLinePhone;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class Customer implements JsonSerializable
{
    protected ?string $merchant_customer_id;
    protected ?string $full_name;
    protected ?Document $document;
    protected ?Gender $gender;
    protected ?DateTime $birth_date;
    protected ?Email $email;
    protected ?MobilePhone $mobile_phone;
    protected ?FixedLinePhone $phone;

    public function __construct(
        ?string $merchant_customer_id,
        ?string $full_name,
        ?Document $document,
        ?Gender $gender,
        ?DateTime $birth_date,
        ?Email $email,
        ?MobilePhone $mobile_phone,
        ?FixedLinePhone $phone
    ) {
        $this->merchant_customer_id = is_null($merchant_customer_id) ? $merchant_customer_id : mb_strcut(trim($merchant_customer_id), 0, 256);
        $this->full_name = is_null($full_name) ? $full_name : mb_strcut(trim($full_name), 0, 128);
        $this->document = $document;
        $this->gender = $gender;
        $this->birth_date = $birth_date;
        $this->email = $email;
        $this->mobile_phone = $mobile_phone;
        $this->phone = $phone;

        $this->assertValidMerchantCustomerId();
        $this->assertValidFullname();
        $this->assertValidBirthdate();
    }

    protected function assertValidMerchantCustomerId(): void
    {
        DomainException::assert(is_null($this->merchant_customer_id) || preg_match('/^[0-9a-zA-Z_-]{1,255}$/', $this->merchant_customer_id), "Merchant Customer ID not exceed maximum length");
    }

    protected function assertValidFullname(): void
    {
        if (is_null($this->full_name)) return;

        $len = mb_strlen($this->full_name);
        DomainException::assert($len > 0 && $len <= 128, "Full name should not be empty or is too long to be accepted.");
    }

    protected function assertValidBirthdate(): void
    {
        if (is_null($this->birth_date)) return;

        $now = new DateTime();
        $diff = $now->diff($this->birth_date);

        $this->birth_date = $diff->y >= 1 ? $this->birth_date : null;
    }

    public function __toString(): string
    {
        return $this->full_name ?? '';
    }

    public function jsonSerialize(): mixed
    {
        return [
            'merchant_customer_id' => $this->merchant_customer_id,
            'full_name' => $this->full_name,
            'document' => $this->document?->jsonSerialize(),
            'gender' => $this->gender ? (string)$this->gender : null,
            'birth_date' => $this->birth_date ? $this->birth_date->format('Y-m-d') : null,
            'email' => $this->email ? (string)$this->email : null,
            'mobile_phone' => $this->mobile_phone ? (string)$this->mobile_phone : null,
            'phone' => $this->phone ? (string)$this->phone : null,
        ];
    }
}
