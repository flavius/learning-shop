<?php


namespace App\PaymentSDK;


use App\PaymentSDK\ValueObject\GatewaySecret;
use App\PaymentSDK\ValueObject\Maid;

interface PaymentMethodConfig
{

    public function getAbbreviation(): string;

    public function getPaymentMethod(): PaymentMethod;

    public function getGatewayUrl(): string;

    public function getGatewayUsername(): string;

    public function getGatewayPassword(): string;

    public function getMaid(): Maid;

    public function getGatewaySecret(): GatewaySecret;

    public function getPaymentMethodFQCN();

}