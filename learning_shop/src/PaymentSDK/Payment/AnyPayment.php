<?php


namespace App\PaymentSDK\Payment;


use App\PaymentSDK\Payment;
use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\Valuable;

class AnyPayment implements Payment
{

    /**
     * @var Valuable
     */
    private $valuable;
    /**
     * @var PaymentMethod
     */
    private $method;

    public function __construct(Valuable $valuable, PaymentMethod $method)
    {
        $this->valuable = $valuable;
        $this->method = $method;
    }

    public function getValuable(): Valuable
    {
        return $this->valuable;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->method;
    }
}