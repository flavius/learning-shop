<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\PaymentMethod;

trait BancontactConfigImpl
{
    public function getPaymentMethod(): PaymentMethod
    {
        return new PaymentMethod\BancontactTransaction($this);
    }

    public function getPaymentMethodFQCN()
    {
        return BancontactTransaction::class;
    }

    public function getAbbreviation(): string
    {
        return \Wirecard\PaymentSdk\Transaction\BancontactTransaction::NAME;
    }
}