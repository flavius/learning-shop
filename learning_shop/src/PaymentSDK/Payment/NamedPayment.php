<?php


namespace App\PaymentSDK\Payment;


use App\PaymentSDK\Payment;
use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\Valuable;
use App\PaymentSDK\Valuable\NamedValuable;

class NamedPayment implements Payment
{

    /**
     * @var NamedValuable
     */
    private $valuable;
    /**
     * @var PaymentMethod
     */
    private $method;

    public function __construct(NamedValuable $valuable, PaymentMethod $method)
    {
        $this->valuable = $valuable;
        $this->method = $method;
    }

    /**
     * @return NamedValuable
     */
    public function getValuable(): Valuable
    {
        return $this->valuable;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->method;
    }
}