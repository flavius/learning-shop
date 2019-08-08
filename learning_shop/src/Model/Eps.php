<?php


namespace App\Model;


use App\Model\ValueObject\BankAccount;
use Wirecard\PaymentSdk\Entity\Redirect;

class Eps implements PaymentMethod, HasBankAccount, HasRedirect
{

    /**
     * @var BankAccount
     */
    private $bankAccount;
    /**
     * @var Redirect
     */
    private $redirect;

    public function __construct(BankAccount $bankAccount, Redirect $redirect)
    {
        $this->bankAccount = $bankAccount;
        $this->redirect = $redirect;
    }

    public function setBankAccount(BankAccount $bankAccount)
    {
        // TODO: Implement setBankAccount() method.
    }

    public function getRedirect(\Wirecard\PaymentSdk\Entity\Redirect $param)
    {
        // TODO: Implement setRedirect() method.
    }
}