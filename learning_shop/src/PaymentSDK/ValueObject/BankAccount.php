<?php


namespace App\PaymentSDK\ValueObject;


class BankAccount
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
        if (strlen($iban) != 18 && !$bic) {
            throw new \DomainException('Invalid bank account');
        }
        $this->value1 = $iban;
        $this->value2 = $bic;
    }

    public function getLegacyBankAccount(): \Wirecard\PaymentSdk\Entity\BankAccount {
        $bankAccount = new \Wirecard\PaymentSdk\Entity\BankAccount();
        if($this->value1) {
            $bankAccount->setIban($this->value1);
        }
        if($this->value2) {
            $bankAccount->setBic($this->value2);
        }
        return $bankAccount;
    }
}