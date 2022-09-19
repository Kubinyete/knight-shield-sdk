<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person\Validation;

interface LocaleValidatorInterface
{
    function validateAsTaxId(string $value): string;
    function validateAsIdCard(string $value): string;
    function validateAsPassport(string $value): string;
}
