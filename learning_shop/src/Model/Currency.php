<?php


namespace App\Model;


use App\Model\ValueObject\ExchangeRate;

class Currency
{

    /**
     * @var string
     */
    private $abbreviation;

    /**
     * @var float
     */
    private $exchangeRate;

    public function __construct(string $abbreviation)
    {
        if(false === preg_match('/^[A-Z]{2,3}$/', $abbreviation)) {
            throw new \DomainException('Invalid currency abbreviation');
        }
        $this->abbreviation = $abbreviation;
        $this->exchangeRate = new ExchangeRate(1.0);
    }

    public function newCurrency(string $abbreviation, ExchangeRate $exchangeRate)
    {
        $currency = new Currency($abbreviation);
        $currency->exchangeRate = $exchangeRate;
        return $currency;
    }

    /**
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

}