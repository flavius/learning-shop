<?php


namespace App\PaymentSDK;

use App\PaymentSDK\Payment\AnyPayment;
use App\PaymentSDK\Payment\NamedPayment;
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
//        $paymentMethod = $payment->getPaymentMethod();
//
//        $transaction = $paymentMethod->newLegacyTransaction();
//        $legacyConfig = $this->config->getLegacyConfig($paymentMethod->getConfig());
//        $transactionService = new TransactionService($legacyConfig);
//        return $transactionService->pay($transaction);


        $paymentMethodConfig = $this->config->getPaymentMethodConfig($methodName);

        $config = $this->config->getLegacyConfig($paymentMethodConfig);
        $amount = $valuable->getAmount()->getLegacyAmount();
        $paymentMethod = $paymentMethodConfig->getPaymentMethod();
        if($valuable instanceof HasShortDescription) {
            $payment = new NamedPayment($valuable, $paymentMethod);
        } else {
            $payment = new AnyPayment($valuable, $paymentMethod);
        }

        $transaction = $paymentMethod->newLegacyTransaction($payment);
        if($valuable instanceof HasShortDescription) {
            $transaction->setDescriptor($valuable->getDescription());
        }

        $transaction->setAmount($amount);

        $transactionService = new TransactionService($config);
        $response = $transactionService->pay($transaction);
        return $response;
    }

    public function decodeResponse(RequestEnvironment $environment)
    {
        $decoderFactory = new ResponseDecoderFactory($environment, $this->config);
        $decoder = $decoderFactory->getDecoder();
        return $decoder->getLegacyResponse();
    }
}