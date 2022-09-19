<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\DocumentLocaleValidator;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\Exception\ValidationNotImplementedException;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class Document implements JsonSerializable, Stringable
{
    protected CountryCode $nationality;
    protected string $value;
    protected DocumentType $type;

    public function __construct(
        CountryCode $nationality,
        string $value,
        DocumentType $type
    ) {
        $this->nationality = $nationality;
        $this->type = $type;
        $this->value = $this->assertValueIsCorrect($value);
    }

    protected function assertValueIsCorrect(string $value): string
    {
        $value = trim($value);

        try {
            $validator = new DocumentLocaleValidator($this->nationality);

            switch ((string)$this->type) {
                case DocumentType::TAX_ID:
                    $value = $validator->getLocaleValidator()->validateAsTaxId($value);
                case DocumentType::ID_CARD:
                    $value = $validator->getLocaleValidator()->validateAsIdCard($value);
                case DocumentType::PASSPORT:
                    $value = $validator->getLocaleValidator()->validateAsPassport($value);
            }
        } catch (ValidationNotImplementedException $e) {
        }

        DomainException::assert(strlen($value) > 0, "Cannot specify an empty document number");
        return $value;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
