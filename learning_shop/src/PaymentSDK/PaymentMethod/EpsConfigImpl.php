<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\PaymentMethod;

trait EpsConfigImpl
{
    public function getPaymentMethod(): PaymentMethod
    {
        $method = new PaymentMethod\EpsTransaction($this);
        return $method;
    }

    public function getPaymentMethodFQCN()
    {
        return EpsTransaction::class;
    }

    public function getAbbreviation(): string
    {
        return \Wirecard\PaymentSdk\Transaction\EpsTransaction::NAME;
    }
}