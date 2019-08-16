<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\ValueObject;

class Descriptor implements ValueObject
{
    use SingleValueObject;

    public function __construct(string $raw)
    {
        $raw = trim($raw);
        if (!$raw) {
            throw new \DomainException('Descriptor cannot be empty');
        }
        $this->value = $raw;
    }

}