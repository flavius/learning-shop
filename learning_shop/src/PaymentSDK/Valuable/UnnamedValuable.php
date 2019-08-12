<?php


namespace App\Valuable;


use App\PaymentSDK\Valuable;
use App\PaymentSDK\ValueObject\Amount;

class UnnamedValuable implements Valuable
{

    /**
     * @var Amount
     */
    private $amount;

    public function __construct(Amount $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }
}