<?php


namespace App\Model;

use App\Model\ValueObject\BankAccount;

/**
 * Class PaymentGatewayConfig
 * @package App\Model
 *
 * Each Shop Plugin would have a specific implementation
 */
interface PaymentGatewayConfig
{
    public function getSuccessUrl();

    public function getCancelUrl();

    public function getFailureUrl();

    public function newPaymentGateway() : PaymentGateway;

    public function getBankAccount(): BankAccount;
}