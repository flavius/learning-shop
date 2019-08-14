<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\PaymentMethod;

trait IdealConfigImpl
{
    public function getPaymentMethod(): PaymentMethod
    {
        $method = new PaymentMethod\IdealTransaction($this);
        return $method;
    }

    public function getPaymentMethodFQCN()
    {
        return IdealTransaction::class;
    }

    public function getAbbreviation(): string
    {
        return \Wirecard\PaymentSdk\Transaction\IdealTransaction::NAME;
    }
}