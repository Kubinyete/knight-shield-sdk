<?php

namespace Kubinyete\KnightShieldSdk\Domain\Order;

use DateInterval;
use DateTime;
use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Contact\Email;
use Kubinyete\KnightShieldSdk\Domain\Contact\FixedLinePhone;
use Kubinyete\KnightShieldSdk\Domain\Contact\MobilePhone;
use Kubinyete\KnightShieldSdk\Domain\Person\Document;
use Kubinyete\KnightShieldSdk\Domain\Person\Gender;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class Customer implements JsonSerializable
{
    protected ?string $merchant_customer_id;
    protected string $full_name;
    protected Document $document;
    protected ?Gender $gender;
    protected ?DateTime $birth_date;
    protected ?Email $email;
    protected ?MobilePhone $mobile_phone;
    protected ?FixedLinePhone $phone;

    public function __construct(
        ?string $merchant_customer_id,
        string $full_name,
        Document $document,
        ?Gender $gender,
        ?DateTime $birth_date,
        ?Email $email,
        ?MobilePhone $mobile_phone,
        ?FixedLinePhone $phone
    ) {
        $this->merchant_customer_id = $merchant_customer_id ? mb_strcut(trim($merchant_customer_id), 0, 256) : $merchant_customer_id;
        $this->full_name = mb_strcut(trim($full_name), 0, 128);
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
        $len = strlen($this->full_name);
        DomainException::assert($len > 0 && $len <= 128, "Full name should not be empty or is too long to be accepted.");
    }

    protected function assertValidBirthdate(): void
    {
        if (!$this->birth_date) return;

        $now = new DateTime();
        $diff = $now->diff($this->birth_date);
        DomainException::assert($diff->y >= 12, "Birth date doesn't make sense and cannot be accepted.");
    }

    public function __toString(): string
    {
        return $this->full_name;
    }

    public function jsonSerialize()
    {
        return [
            'merchant_customer_id' => $this->merchant_customer_id,
            'full_name' => $this->full_name,
            'document' => $this->document->jsonSerialize(),
            'gender' => $this->gender ? (string)$this->gender : null,
            'birth_date' => $this->birth_date ? $this->birth_date->format('Y-m-d') : null,
            'email' => $this->email ? (string)$this->email : null,
            'mobile_phone' => $this->mobile_phone ? (string)$this->mobile_phone : null,
            'phone' => $this->phone ? (string)$this->phone : null,
        ];
    }
}
