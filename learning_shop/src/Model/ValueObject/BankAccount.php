<?php


namespace App\Model\ValueObject;


use App\Infrastructure\DoubleValueObject;
use App\Model\ValueObject;

/**
 * Class BankAccount
 * @package App\Model\ValueObject
 *
 * To introduce american bank accounts, turn this class into an interface, and split up the implementations, each with its specific constructor.
 */
class BankAccount implements ValueObject
{
    use DoubleValueObject;

    /**
     * BankAccount constructor.
     * @param string $iban
     * @param string $bic
     *
     * @todo more validation
     */
    public function __construct(string $iban, string $bic)
    {
        if(strlen($iban) != 18) {
            throw new \DomainException('Invalid bank account');
        }
        $this->value1 = $iban;
        $this->value2 = $bic;
    }

}