<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person\Validation\Validators;

use Kubinyete\KnightShieldSdk\Domain\Person\Cnpj;
use Kubinyete\KnightShieldSdk\Domain\Person\Cpf;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\LocaleValidator;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class BRLocaleValidator extends LocaleValidator
{
    public function validateAsTaxId(string $value): string
    {
        $cpf = $cnpj = null;

        try {
            $cpf = new Cpf($value);
        } catch (DomainException $e) {
        }

        try {
            $cnpj = new Cnpj($value);
        } catch (DomainException $e) {
        }

        DomainException::assert($cpf || $cnpj, "Document is neither an valid CPF or CNPJ.");
        return (string)($cpf ? $cpf : $cnpj);
    }

    public function validateAsIdCard(string $value): string
    {
        return $value;
    }

    public function validateAsPassport(string $value): string
    {
        return $value;
    }
}
