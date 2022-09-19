<?php

namespace Tests;

use Kubinyete\KnightShieldSdk\App\ApiClient;
use Kubinyete\KnightShieldSdk\Domain\Contact\Email;
use Kubinyete\KnightShieldSdk\Domain\Contact\MobilePhone;
use Kubinyete\KnightShieldSdk\Domain\Locale\CountryCode;
use Kubinyete\KnightShieldSdk\Domain\Person\Document;
use Kubinyete\KnightShieldSdk\Domain\Person\DocumentType;
use Kubinyete\KnightShieldSdk\Domain\Person\Gender;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class DomainCustomerTest extends TestCase
{
    public function testCannotCreateInvalidDocument()
    {
        $this->expectException(DomainException::class);
        $document = new Document(CountryCode::br(), '123.123.123-22', DocumentType::taxId());
    }

    public function testCanCreatedValidDocument()
    {
        $number = '863.722.120-30';
        $document = new Document(CountryCode::br(), $number, DocumentType::taxId());
        $this->assertEquals($number, (string)$document);
    }

    public function testCanCreatedDocumentWithoutSupportedValidation()
    {
        $number = '12949021424';
        $document = new Document(CountryCode::br(), $number, DocumentType::passport());
        $this->assertEquals($number, (string)$document);
    }

    public function testCannotCreateEmptyDocumentWithoutSupportedValidation()
    {
        $this->expectException(DomainException::class);
        $document = new Document(CountryCode::br(), '', DocumentType::passport());
    }

    //

    public function testCannotCreateInvalidGenders()
    {
        $this->expectException(DomainException::class);
        $gender = new Gender('A');
    }

    public function testCanCreateValidGenders()
    {
        $genderM = new Gender($m = 'M');
        $genderF = new Gender($f = 'F');
        $this->assertEquals($m, (string)$genderM);
        $this->assertEquals($f, (string)$genderF);
    }

    //

    public function testCannotCreateInvalidEmails()
    {
        $this->expectException(DomainException::class);
        $email = new Email('teste@');
    }

    public function testCanCreateValidEmails()
    {
        $name = 'teste@domain.a';
        $email = new Email($name);
        $this->assertEquals($name, (string)$email);
    }

    //

    public function testCannotCreateInvalidMobilePhone()
    {
        $this->expectException(DomainException::class);
        $phone = new MobilePhone('123@123');
    }

    public function testCanCreateValidMobilePhoneInternational()
    {
        $expectedPhoneString = '+5518998227323';
        $phone = new MobilePhone($expectedPhoneString);
        $this->assertEquals($expectedPhoneString, (string)$phone);
    }

    public function testCanCreateValidMobilePhoneInternationalWithoutSymbol()
    {
        $phoneString = '+5518998227323';
        $expectedPhoneString = "+$phoneString";

        $phone = new MobilePhone($phoneString);
        $this->assertEquals($expectedPhoneString, (string)$phone);
    }

    public function testCanCreateValidMobilePhoneInternationalImplicit()
    {
        $phoneString = '18998227323';
        $expectedPhoneString = "+55$phoneString";

        $phone = new MobilePhone($phoneString);
        $this->assertEquals($expectedPhoneString, (string)$phone);
    }
}
