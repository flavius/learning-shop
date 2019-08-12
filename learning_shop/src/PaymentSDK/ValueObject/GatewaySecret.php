<?php


namespace App\PaymentSDK\ValueObject;


class GatewaySecret
{

    use SingleValueObject;

    public function __construct(string $rawSecret)
    {
        if(strlen($rawSecret) != 36) {
            throw new \DomainException("invalid secret");
        }
        $this->value = $rawSecret;
    }

}