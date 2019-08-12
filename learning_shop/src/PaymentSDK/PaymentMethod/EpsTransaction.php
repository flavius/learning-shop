<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\PaymentMethod;
use Wirecard\PaymentSdk\Entity\Redirect;

class EpsTransaction implements PaymentMethod
{

    /**
     * @var EpsConfig
     */
    private $config;

    public function __construct(EpsConfig $config)
    {
        $this->config = $config;
    }

    public function newLegacyTransaction(): \Wirecard\PaymentSdk\Transaction\Transaction {
        $transaction = new \Wirecard\PaymentSdk\Transaction\EpsTransaction();
        $redirect = new Redirect(
            $this->config->getSuccessUrl(),
            $this->config->getCancelUrl(),
            $this->config->getFailureUrl(),
        );
        $transaction->setRedirect($redirect);
        $bankAccount = $this->config->getBankAccount()->getLegacyBankAccount();
        $transaction->setBankAccount($bankAccount);

        return $transaction;
    }

    public function getSuccessUrl()
    {
        return $this->config->getSuccessUrl();
    }

    public function getCancelUrl()
    {
        return $this->config->getCancelUrl();
    }

    public function getFailureUrl()
    {
        return $this->config->getFailureUrl();
    }
}