<?php


namespace App\Model;


use App\Model\ValueObject\ExchangeRate;

class CurrencyManager
{

    private $currencies = [];

    /**
     * @var Currency
     */
    private $primaryCurrency;

    public function __construct(Currency $primaryCurrency)
    {
        $this->primaryCurrency = $primaryCurrency;
        $this->currencies[$primaryCurrency->getAbbreviation()] = $primaryCurrency;
    }

    public function getCurrencyByAbbreviation(string $abbreviation)
    {
        if (!isset($this->currencies[$abbreviation])) {
            throw new \OutOfBoundsException('Currency unknown');
        }
        return $this->currencies[$abbreviation];
    }

    public function newCurrency(string $abbreviation, ExchangeRate $exchangeRate)
    {
        $currency = $this->primaryCurrency->newCurrency($abbreviation, $exchangeRate);
        $this->currencies[$abbreviation] = $currency;
        return $this->currencies[$abbreviation];
    }

    public function getPrimaryCurrency()
    {
        return $this->primaryCurrency;
    }

}