<?php


namespace App\Model;


use App\Model\ValueObject\BankAccount;

interface HasBankAccount
{

    public function setBankAccount(BankAccount $bankAccount);

}