<?php


namespace App\ShopPlugin;


use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\PaymentMethod\GiropayConfig;
use App\PaymentSDK\ValueObject\BankAccount;
use App\PaymentSDK\ValueObject\GatewaySecret;
use App\PaymentSDK\ValueObject\Maid;

class LearningGiropayConfig implements GiropayConfig
{

    use PaymentMethod\GiropayConfigImpl;
    /**
     * @var LearningShopGatewayConfig
     */
    private $config;

    /**
     * LearningGiropayConfig constructor.
     * @param LearningShopGatewayConfig $config
     */
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
        return new Maid('9b4b0e5f-1bc8-422e-be42-d0bad2eadabc');
    }

    public function getGatewaySecret(): GatewaySecret
    {
        return new GatewaySecret('0c8c6f3a-1534-4fa1-99d9-d1c644d43709');
    }

    public function getBankAccount(): BankAccount
    {
        return new BankAccount('', 'GENODETT488');
    }

}