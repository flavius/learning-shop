<?php


namespace App\PaymentSDK;


use App\PaymentSDK\ValueObject\BankAccount;

interface HasBankAccount
{
    public function getBankAccount(): BankAccount;
}