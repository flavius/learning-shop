<?php


namespace App\PaymentSDK\Valuable;


use App\PaymentSDK\Valuable;
use App\PaymentSDK\ValueObject\Amount;
use App\PaymentSDK\ValueObject\Currency;

class ValuableCollection implements Valuable
{

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var UnnamedCountedValuable[]
     */
    private $valuables = [];

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function getAmount(): Amount
    {
        $total = new Amount(0, $this->currency);
        foreach ($this->valuables as $valuable) {
            $total += $valuable->getAmount();
        }
    }

    public function addValuable(UnnamedCountedValuable $valuable) {
        if(!$this->currency->equals($valuable->getAmount()->getCurrency())) {
            throw new \DomainException('Cannot mix valuables of different currencies in the same collection');
        }
        $this->valuables[] = $valuable;
    }
}