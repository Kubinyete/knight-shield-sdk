<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person\Validation;

use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\Exception\ValidationNotImplementedException;
use Kubinyete\KnightShieldSdk\Domain\Person\Validation\Validators\BRLocaleValidator;
use UnexpectedValueException;

class DocumentLocaleValidator
{
    protected CountryCode $countryCode;
    protected LocaleValidatorInterface $validator;

    private const LOCALE_VALIDATOR_CLASSMAP = [
        'BR' => BRLocaleValidator::class,
    ];

    public function __construct(CountryCode $countryCode)
    {
        $this->countryCode = $countryCode;
        $this->validator = $this->getSupportedValidatorByCountryCode($countryCode);
    }

    protected function getSupportedValidatorByCountryCode(CountryCode $countryCode): LocaleValidatorInterface
    {
        $className = array_key_exists((string)$countryCode, self::LOCALE_VALIDATOR_CLASSMAP) ? self::LOCALE_VALIDATOR_CLASSMAP[(string)$countryCode] : null;
        ValidationNotImplementedException::assert($className != null);

        $instance = new $className();

        if (!$instance instanceof LocaleValidatorInterface) {
            throw new UnexpectedValueException("Validator for country code $countryCode does not implements " . LocaleValidatorInterface::class);
        }

        return $instance;
    }

    public function getLocaleValidator(): LocaleValidatorInterface
    {
        return $this->validator;
    }
}
