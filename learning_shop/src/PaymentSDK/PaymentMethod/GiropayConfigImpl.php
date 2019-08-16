<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\Payment;
use App\PaymentSDK\PaymentMethod;

trait GiropayConfigImpl
{
    public function getPaymentMethod(): PaymentMethod
    {
        $method = new PaymentMethod\GiropayTransaction($this);
        return $method;
    }

    public function getPaymentMethodFQCN()
    {
        return GiropayTransaction::class;
    }

    public function getAbbreviation(): string
    {
        return \Wirecard\PaymentSdk\Transaction\GiropayTransaction::NAME;
    }

}