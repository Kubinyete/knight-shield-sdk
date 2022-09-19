<?php

namespace Kubinyete\KnightShieldSdk\Domain\Order;

use DateTime;
use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Contact\Email;
use Kubinyete\KnightShieldSdk\Domain\Contact\FixedLinePhone;
use Kubinyete\KnightShieldSdk\Domain\Contact\MobilePhone;
use Kubinyete\KnightShieldSdk\Domain\Person\Document;
use Kubinyete\KnightShieldSdk\Domain\Person\Gender;

class Customer implements JsonSerializable
{
    protected string $full_name;
    protected Document $document;
    protected ?Gender $gender;
    protected DateTime $birth_date;
    protected Email $email;
    protected MobilePhone $mobile_phone;
    protected ?FixedLinePhone $phone;

    public function __construct(
        string $full_name,
        Document $document,
        Gender $gender,
        DateTime $birth_date,
        Email $email,
        MobilePhone $mobile_phone,
        FixedLinePhone $phone,
    ) {
        $this->full_name = $full_name;
        $this->document = $document;
        $this->gender = $gender;
        $this->birth_date = $birth_date;
        $this->email = $email;
        $this->mobile_phone = $mobile_phone;
        $this->phone = $phone;
    }

    public function __toString(): string
    {
        return $this->full_name;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
