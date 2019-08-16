<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\Payment;
use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\PaymentMethodConfig;
use Wirecard\PaymentSdk\Entity\Redirect;
use Wirecard\PaymentSdk\Transaction\Transaction;

class SofortTransaction implements PaymentMethod
{

    /**
     * @var SofortConfig
     */
    private $config;

    public function __construct(SofortConfig $config)
    {
        $this->config = $config;
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

    public function newLegacyTransaction(Payment $payment): Transaction
    {
        if(!($payment instanceof Payment\NamedPayment)) {
            throw new \RuntimeException("Payment must be a NamedPayment, got instead: ". get_class($payment));
        }
        $transaction = new \Wirecard\PaymentSdk\Transaction\SofortTransaction();
        $redirect = new Redirect(
            $this->getSuccessUrl(),
            $this->getCancelUrl(),
            $this->getFailureUrl(),
            );
        $transaction->setRedirect($redirect);
        $description = $payment->getValuable()->getDescription();
        $transaction->setDescriptor($description);

        return $transaction;
    }

    public function getConfig(): PaymentMethodConfig
    {
        return $this->config;
    }
}