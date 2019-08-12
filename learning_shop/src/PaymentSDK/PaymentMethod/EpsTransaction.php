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

    public function newLegacyTransaction(): \Wirecard\PaymentSdk\Transaction\Transaction
    {
        $transaction = new \Wirecard\PaymentSdk\Transaction\EpsTransaction();
        $redirect = new Redirect(
            $this->getSuccessUrl(),
            $this->getCancelUrl(),
            $this->getFailureUrl(),
            );
        $transaction->setRedirect($redirect);
        $bankAccount = $this->config->getBankAccount()->getLegacyBankAccount();
        $transaction->setBankAccount($bankAccount);

        return $transaction;
    }

    public function getSuccessUrl()
    {
        $url = $this->config->getSuccessUrl();
        $name = $this->config->getAbbreviation();
        $url .= '?name=' . $name;//TODO: generating http-specific parameters here is not clean, as every shop might be different
        return $url;
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