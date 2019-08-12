<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\ValueObject;

class Currency implements ValueObject
{
    use SingleValueObject;

    public function __construct(string $abbreviation)
    {
        $abbrevs = ['EUR', 'USD'];
        if(!in_array($abbreviation, $abbrevs)) {
            throw new \DomainException('Invalid Currency');
        }
        $this->value = $abbreviation;
    }
}