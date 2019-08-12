<?php


namespace App\PaymentSDK;


use Wirecard\PaymentSdk\Transaction\Transaction;

interface PaymentMethod extends HasPluginUrlEndpoints
{

    public function newLegacyTransaction() : Transaction;

}