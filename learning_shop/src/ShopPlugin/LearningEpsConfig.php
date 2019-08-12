<?php


namespace App\ShopPlugin;


use App\PaymentSDK\PaymentMethod;
use App\PaymentSDK\PaymentMethod\EpsConfig;
use App\PaymentSDK\ValueObject\BankAccount;
use App\PaymentSDK\ValueObject\GatewaySecret;
use App\PaymentSDK\ValueObject\Maid;

/**
 * Class LearningEpsConfig
 * @package App\ShopPlugin
 *
 * Hard-coded values in this class would actually be fetched from the DB.
 */
class LearningEpsConfig implements EpsConfig
{

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

    public function getAbbreviation(): string
    {
        return \Wirecard\PaymentSdk\Transaction\EpsTransaction::NAME;
    }

    public function getMaid(): Maid
    {
        return new Maid('1f629760-1a66-4f83-a6b4-6a35620b4a6d');
    }

    public function getGatewaySecret(): GatewaySecret
    {
        return new GatewaySecret('20c6a95c-e39b-4e6a-971f-52cfb347d359');
    }

    public function getBankAccount(): BankAccount
    {
        return new BankAccount('NL13TEST0123456789', 'BWFBATW1XXX');
    }

    public function getPaymentMethod(): PaymentMethod
    {
        $method = new PaymentMethod\EpsTransaction($this);
        return $method;
    }
}