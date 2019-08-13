<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\HasPluginUrlEndpoints;
use App\PaymentSDK\PaymentMethodConfig;

interface IdealConfig extends HasPluginUrlEndpoints, PaymentMethodConfig
{

    public function getBic(): string;
}