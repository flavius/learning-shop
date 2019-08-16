<?php


namespace App\ShopPlugin;


use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\PaymentMethod\BancontactConfig;
use App\PaymentSDK\ValueObject\BankAccount;
use App\PaymentSDK\ValueObject\GatewaySecret;
use App\PaymentSDK\ValueObject\Maid;

class LearningBancontactConfig implements BancontactConfig
{
    use PaymentMethod\BancontactConfigImpl;

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
        return new Maid('86f03c98-6691-421d-94c8-232c3d5c2573');
    }

    public function getGatewaySecret(): GatewaySecret
    {
        return new GatewaySecret('20c6a95c-e39b-4e6a-971f-52cfb347d359');
    }

    public function getBankAccount(): BankAccount
    {
        return new BankAccount('NL13TEST0123456789', 'BWFBATW1XXX');
    }
}