<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\Payment;
use App\PaymentSDK\PaymentMethod;

trait SofortConfigImpl
{
    public function getPaymentMethod(): PaymentMethod
    {
        $method = new SofortTransaction($this);
        return $method;
    }

    public function getPaymentMethodFQCN()
    {
        return SofortTransaction::class;
    }

    public function getAbbreviation(): string
    {
        return \Wirecard\PaymentSdk\Transaction\SofortTransaction::NAME;
    }
}