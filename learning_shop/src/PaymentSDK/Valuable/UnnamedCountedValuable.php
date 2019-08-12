<?php


namespace App\PaymentSDK\Valuable;


use App\PaymentSDK\Valuable;
use App\PaymentSDK\ValueObject\Amount;

class UnnamedCountedValuable implements Valuable
{

    /**
     * @var Amount
     */
    private $itemAmount;
    /**
     * @var int
     */
    private $count;

    public function __construct(Amount $itemAmount, int $count)
    {
        if($count < 0) {
            throw new \DomainException('Count cannot be negative');
        }
        $this->itemAmount = $itemAmount;
        $this->count = $count;
    }

    public function getAmount(): Amount
    {
        return $this->itemAmount->multiplyBy($this->count);
    }
}