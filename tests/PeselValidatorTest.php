<?php

use PHPUnit\Framework\TestCase;


//to run tests : vendor\bin\phpunit tests
class PeselValidatorTest extends TestCase
{

    private $peselValidator;

    function setUp(): void
    {
        $this->peselValidator = new PeselValidator();
    }

    function testValidateCorrectPesel()
    {

        $this->assertEquals(true, $this->peselValidator->isValid('95042551825'));
    }

    function testValidateCorrectPeselFrom21stCentury()
    {

        $this->assertEquals(true, $this->peselValidator->isValid('20261086245'));
    }

    function testValidateIncorrectPeselWithWrongControlDigit()
    {

        $this->assertEquals(false, $this->peselValidator->isValid('20261086243'));
    }

    function testValidateIncorrectPeselWithWrongDate()
    {

        $this->assertEquals(false, $this->peselValidator->isValid('95142551825'));
    }

    function testValidateTooShortPesel()
    {

        $this->assertEquals(false, $this->peselValidator->isValid('9514255182'));
    }

    function testValidatePeselNotOnlyDigits()
    {

        $this->assertEquals(false, $this->peselValidator->isValid('9514d55182a'));
    }

}