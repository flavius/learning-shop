<?php


namespace App\Model;


use Wirecard\PaymentSdk\Entity\Amount;

class UnnamedValue implements Valuable
{
    /**
     * @var float
     */
    private $number;

    /**
     * @var Currency
     */
    private $currency;

    public function __construct(float $number, Currency $currency)
    {
        $this->number = $number;
        $this->currency = $currency;
    }

    public function getAmount(): Amount
    {
        return new Amount($this->number, $this->currency->getAbbreviation());
    }
}