<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\HasPluginUrlEndpoints;
use App\PaymentSDK\PaymentMethodConfig;
use App\PaymentSDK\ValueObject\BankAccount;

interface EpsConfig extends HasPluginUrlEndpoints, PaymentMethodConfig
{
    public function getBankAccount(): BankAccount;

}