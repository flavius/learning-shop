<?php


namespace App\PaymentSDK;


use App\PaymentSDK\ResponseDecoder\IdealResponseDecoder;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use App\PaymentSDK\ResponseDecoder\EmptyDecoder;
use App\PaymentSDK\ResponseDecoder\XmlResponseDecoder;
use Wirecard\PaymentSdk\TransactionService;

class ResponseDecoderFactory
{
    /**
     * @var RequestEnvironment
     */
    private $environment;
    /**
     * @var PaymentGatewayConfig
     */
    private $gatewayConfig;

    public function __construct(RequestEnvironment $environment, PaymentGatewayConfig $gatewayConfig)
    {
        $this->environment = $environment;
        $this->gatewayConfig = $gatewayConfig;
    }

    public function getDecoder(): ResponseDecoder
    {
        if ($this->environment->hasQueryParameter('name')) {
            try {
                $method = new PaymentMethodFQCN($this->environment->getQueryParameter('name'));
                switch ($method->getShortName()) {//TODO: use the payment method registry
                    case 'eps':
                    case 'giropay':
                        return $this->getXmlResponse($method);
                    case 'ideal':
                        return $this->getIdealResponse();
                }
            } catch (\Exception $e) {
                return new EmptyDecoder();
            }
        }
        return new EmptyDecoder();
    }

    private function getXmlResponse(PaymentMethodFQCN $methodFQCN)
    {
        if (!$this->environment->hasQueryParameter('eppresponse')) {
            return new EmptyDecoder();
        }
        $config = $this->gatewayConfig->getPaymentMethodConfig($methodFQCN);
        return new XmlResponseDecoder($this->environment->getQueryParameter('eppresponse'),$this->gatewayConfig ,$config);
    }

    private function getIdealResponse()
    {
        return new IdealResponseDecoder($this->gatewayConfig, $this->environment);
    }

}