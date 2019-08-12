<?php


namespace App\PaymentSDK;

use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use Wirecard\PaymentSdk\Response\Response;
use Wirecard\PaymentSdk\TransactionService;

class PaymentGateway
{

    /**
     * @var PaymentGatewayConfig
     */
    private $config;

    public function __construct(PaymentGatewayConfig $config)
    {
        $this->config = $config;
    }

    public function pay(Valuable $valuable, PaymentMethodFQCN $methodName): Response {
        $paymentMethodConfig = $this->config->getPaymentMethodConfig($methodName);

        $config = $this->config->getLegacyConfig($paymentMethodConfig);
        $amount = $valuable->getAmount()->getLegacyAmount();

        $transaction = $paymentMethodConfig->getPaymentMethod()->newLegacyTransaction();

        $transaction->setAmount($amount);
        if($valuable instanceof HasShortDescription) {
            $transaction->setDescriptor($valuable->getDescription());
        }
        $transactionService = new TransactionService($config);
        $response = $transactionService->pay($transaction);
        return $response;
    }
}