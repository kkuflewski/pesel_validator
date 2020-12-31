<?php

class PeselValidator
{
    private $pesel;

    public function isValid($pesel)
    {
        $this->pesel = $pesel;

        //check if any validation functions return 'false'
        if (!$this->isNumberWithElevenDigits()) return false;
        if (!$this->isControlDigitCorrect()) return false;
        if (!$this->isDateOfBirthCorrect()) return false;

        //validation passed
        return true;
    }

    public function isNumberWithElevenDigits()
    {
        return preg_match('/^\d{11}$/', $this->pesel);
    }

    public function isDateOfBirthCorrect()
    {
        //first two digits of year in case of pesel's 3rd digit (0,1,2,...,9)
        $firstDigitsOfYears = [19, 19, 20, 20, 21, 21, 22, 22];

        //get year, month and day numbers from PESEL
        $yearNumberFromPesel = substr($this->pesel, 0, 2);
        $dayNumberFromPesel = substr($this->pesel, 4, 2);
        $monthNumberFromPesel = substr($this->pesel, 2, 2);
        $monthFirstDigit = $monthNumberFromPesel[0];
        $monthSecondDigit = $monthNumberFromPesel[1];

        //set real date
        $yearOfBirth = $firstDigitsOfYears[$monthFirstDigit] . $yearNumberFromPesel;
        $monthOfBirth = $monthFirstDigit % 2 . $monthSecondDigit;
        $dayOfBirth = $dayNumberFromPesel;

        //return information if date like that could even exist
        return checkdate($monthOfBirth, $dayOfBirth, $yearOfBirth);
    }

    public function isControlDigitCorrect()
    {
        //get control digit (last cipher)
        $controlDigit = $this->pesel[10];

        //array of weights
        $controlWeights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];

        //count partial products (digit x weight) and take only unity digits
        //and count total sum of products
        $partialProducts = [];
        $totalSum = 0;
        for ($i = 0; $i < 10; $i++) {
            $partialProducts[$i] = ($controlWeights[$i] * $this->pesel[$i]) % 10;
            $totalSum += $partialProducts[$i];
        }

        //count control digit (10 - totalSum(unity digit))
        $countedControlDigit = 10 - $totalSum % 10;

        //compare control digit from pesel to counted control digit - if equal->return true, if not equal->return false
        return ($countedControlDigit == $controlDigit);
    }
}