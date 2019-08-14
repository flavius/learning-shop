<?php


namespace App\PaymentSDK;


use App\PaymentSDK\ValueObject\PaymentMethodFQCN;

interface PaymentGatewayConfig extends HasPluginUrlEndpoints
{
    /**
     * @return PaymentGateway
     *
     * Convenience builder method.
     */
    public function newGateway(): PaymentGateway;

    /**
     * @return PaymentMethodConfig[]
     */
    public function getPaymentConfigs();


    public function getPaymentMethodConfig(PaymentMethodFQCN $methodName): PaymentMethodConfig;

    public function getLegacyConfig(PaymentMethodConfig $paymentMethodConfig): \Wirecard\PaymentSdk\Config\Config;

    public function getPaymentMethodsRegistry(): PaymentMethodRegistry;

}