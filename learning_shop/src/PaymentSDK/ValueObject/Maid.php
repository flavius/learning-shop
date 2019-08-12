<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\ValueObject;

class Maid implements ValueObject
{

    use SingleValueObject;

    public function __construct(string $rawId)
    {
        if(strlen($rawId) != 36) {
            throw new \DomainException("invalid Maid");
        }
        $this->value = $rawId;
    }

}