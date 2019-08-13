<?php


namespace App\PaymentSDK\ResponseDecoder;


use App\PaymentSDK\PaymentGatewayConfig;
use App\PaymentSDK\PaymentMethodConfig;
use App\PaymentSDK\ResponseDecoder;
use Wirecard\PaymentSdk\Mapper\ResponseMapper;
use Wirecard\PaymentSdk\Response\Response as LegacyResponse;

class XmlResponseDecoder implements ResponseDecoder
{

    private $eppResponse;
    /**
     * @var PaymentGatewayConfig
     */
    private $config;
    /**
     * @var PaymentMethodConfig
     */
    private $paymentMethodConfig;

    public function __construct($eppResponse, PaymentGatewayConfig $config, PaymentMethodConfig $paymentMethodConfig)
    {
        $this->eppResponse = $eppResponse;
        $this->config = $config;
        $this->paymentMethodConfig = $paymentMethodConfig;
    }

    public function getLegacyResponse(): LegacyResponse
    {
        $config = $this->config->getLegacyConfig($this->paymentMethodConfig);
        $mapper = new ResponseMapper($config);
        $response = $mapper->map($this->eppResponse);
        return $response;
    }
}