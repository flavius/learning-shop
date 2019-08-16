<?php


namespace App\ShopPlugin;


use App\PaymentSDK\PaymentMethod\SofortConfig;
use App\PaymentSDK\PaymentMethod\SofortConfigImpl;
use App\PaymentSDK\ValueObject\GatewaySecret;
use App\PaymentSDK\ValueObject\Maid;

class LearningSofortConfig implements SofortConfig
{

    use SofortConfigImpl;

    /**
     * @var LearningShopGatewayConfig
     */
    private $config;

    public function __construct(LearningShopGatewayConfig $config)
    {
        $this->config = $config;
    }

    public function getGatewayUrl(): string
    {
        return 'https://api-test.wirecard.com';
    }

    public function getGatewayUsername(): string
    {
        return '16390-testing';
    }

    public function getGatewayPassword(): string
    {
        return '3!3013=D3fD8X7';
    }

    public function getSuccessUrl()
    {
        //
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

    public function getMaid(): Maid
    {
        return new Maid('6c0e7efd-ee58-40f7-9bbd-5e7337a052cd');
    }

    public function getGatewaySecret(): GatewaySecret
    {
        return new GatewaySecret('58764ab3-5c56-450e-b747-7237a24e92a7');
    }
}