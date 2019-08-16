<?php


namespace App\PaymentSDK\PaymentMethod;


use App\PaymentSDK\Payment;
use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\PaymentMethodConfig;
use Wirecard\PaymentSdk\Entity\Redirect;
use Wirecard\PaymentSdk\Transaction\Transaction;

class BancontactTransaction implements PaymentMethod
{

    /**
     * @var BancontactConfig
     */
    private $config;

    public function __construct(BancontactConfig $config)
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
        $url = $this->config->getCancelUrl();
        $name = $this->config->getAbbreviation();
        $url .= '?name=' . $name;//TODO: generating http-specific parameters here is not clean, as every shop might be different
        return $url;
    }

    public function getFailureUrl()
    {
        $url = $this->config->getFailureUrl();
        $name = $this->config->getAbbreviation();
        $url .= '?name=' . $name;//TODO: generating http-specific parameters here is not clean, as every shop might be different
        return $url;
    }

    /**
     * @param Payment $payment
     * @return Transaction
     * @todo remove this param from here to passing payment to PaymentGateway::pay() (pull up).
     */
    public function newLegacyTransaction(Payment $payment): Transaction
    {
        $transaction = new \Wirecard\PaymentSdk\Transaction\BancontactTransaction();
        $redirect = new Redirect(
            $this->getSuccessUrl(),
            $this->getCancelUrl(),
            $this->getFailureUrl(),
            );
        $transaction->setRedirect($redirect);

        return $transaction;
    }

    public function getConfig(): PaymentMethodConfig
    {
        return $this->config;
    }
}