<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\HasPluginUrlEndpoints;
use App\PaymentSDK\PaymentMethodConfig;

interface GiropayConfig extends HasPluginUrlEndpoints, PaymentMethodConfig
{

    public function getBankAccount();
}