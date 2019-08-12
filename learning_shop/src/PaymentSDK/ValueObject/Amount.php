<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\ValueObject;
use App\Valuable\NumericValueObject;
use Wirecard\PaymentSdk\Entity\Amount as LegacyAmount;

class Amount implements ValueObject, NumericValueObject
{

    use DoubleValueObject;

    public function __construct($number, Currency $currency)
    {
        if (!is_numeric($number)) {
            throw new \DomainException('Amount must be numeric');
        }
        $this->value1 = $number;
        $this->value2 = $currency;
    }

    public function getLegacyAmount(): LegacyAmount
    {
        return new LegacyAmount($this->value1, $this->value2->asString());
    }

    public function multiplyBy($multiplier): NumericValueObject
    {
        return new Amount($this->value1 * $multiplier, $this->value2);
    }

    public function getCurrency(): Currency
    {
        return $this->value2;
    }
}