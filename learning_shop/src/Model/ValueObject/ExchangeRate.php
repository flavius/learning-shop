<?php


namespace App\Model\ValueObject;

use App\Infrastructure\SingleValueObject;
use App\Model\ValueObject;

class ExchangeRate implements ValueObject
{
    use SingleValueObject;

    public function __construct(float $value)
    {
        if($value < 0) {
            throw new \DomainException('Exchange rate has to be a positive number');
        }
        $this->value = $value;
    }

}