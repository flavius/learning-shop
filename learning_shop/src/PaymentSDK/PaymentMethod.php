<?php


namespace App\PaymentSDK;


use Wirecard\PaymentSdk\Transaction\Transaction;

interface PaymentMethod extends HasPluginUrlEndpoints
{

    /**
     * @param Payment $payment
     * @return Transaction
     * @todo remove this param from here to passing payment to PaymentGateway::pay() (pull up).
     */
    public function newLegacyTransaction(Payment $payment) : Transaction;

    public function getConfig() : PaymentMethodConfig;

}