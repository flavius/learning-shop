<?php


namespace App\PaymentSDK\ResponseDecoder;


use App\PaymentSDK\PaymentGatewayConfig;
use App\PaymentSDK\PaymentMethod\IdealTransaction;
use App\PaymentSDK\PaymentMethodConfig;
use App\PaymentSDK\RequestEnvironment;
use App\PaymentSDK\ResponseDecoder;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use Wirecard\PaymentSdk\Response\Response as LegacyResponse;
use Wirecard\PaymentSdk\TransactionService;

class IdealResponseDecoder implements ResponseDecoder
{

    /**
     * @var PaymentGatewayConfig
     */
    private $gatewayConfig;
    /**
     * @var RequestEnvironment
     */
    private $environment;

    public function __construct(PaymentGatewayConfig $gatewayConfig, RequestEnvironment $environment)
    {
        $this->gatewayConfig = $gatewayConfig;
        $this->environment = $environment;
    }

    public function getLegacyResponse(): LegacyResponse
    {
        $config = $this->gatewayConfig->getPaymentMethodConfig(new PaymentMethodFQCN(IdealTransaction::class));
        $service = new TransactionService($this->gatewayConfig->getLegacyConfig($config));
        $response = $service->handleResponse($this->environment->getAll());
        return $response;
    }
}