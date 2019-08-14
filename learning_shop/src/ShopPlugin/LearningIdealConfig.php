<?php


namespace App\ShopPlugin;


use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\PaymentMethod\IdealConfig;
use App\PaymentSDK\ValueObject\GatewaySecret;
use App\PaymentSDK\ValueObject\Maid;

class LearningIdealConfig implements IdealConfig
{

    use PaymentMethod\IdealConfigImpl;
    /**
     * @var LearningShopGatewayConfig
     */
    private $config;

    /**
     * LearningIdealConfig constructor.
     * @param LearningShopGatewayConfig $config
     */
    public function __construct(\App\ShopPlugin\LearningShopGatewayConfig $config)
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
        return new Maid('4aeccf39-0d47-47f6-a399-c05c1f2fc819');
    }

    public function getGatewaySecret(): GatewaySecret
    {
        return new GatewaySecret('7a353766-23b5-4992-ae96-cb4232998954');
    }

    public function getBic(): string
    {
        return 'Rabobank';
    }
}