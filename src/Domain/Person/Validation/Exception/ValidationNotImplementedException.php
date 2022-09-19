<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person\Validation\Exception;

use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\Validators\BRLocaleValidator;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Kubinyete\KnightShieldSdk\Shared\Exception\Exception;
use Kubinyete\KnightShieldSdk\Shared\Trait\CanAssert;

class ValidationNotImplementedException extends Exception
{
    use CanAssert;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ? $message : "Validation for specified country code is not yet implemented.");
    }
}
