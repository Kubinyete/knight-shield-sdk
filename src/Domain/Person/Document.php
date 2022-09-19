<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\DocumentLocaleValidator;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\ValidationNotImplementedException;

class Document implements JsonSerializable
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
        try {
            $validator = new DocumentLocaleValidator($this->nationality);

            switch ((string)$this->type) {
                case DocumentType::TAX_ID:
                    return $validator->getLocaleValidator()->validateAsTaxId($value);
                case DocumentType::ID_CARD:
                    return $validator->getLocaleValidator()->validateAsIdCard($value);
                case DocumentType::PASSPORT:
                    return $validator->getLocaleValidator()->validateAsPassport($value);
            }
        } catch (ValidationNotImplementedException $e) {
            return $validator;
        }
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}