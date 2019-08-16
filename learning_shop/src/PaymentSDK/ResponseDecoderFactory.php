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
                $registry = $this->gatewayConfig->getPaymentMethodsRegistry();
                $method = new PaymentMethodFQCN($this->environment->getQueryParameter('name'), $registry);
                $getXmlResponse = function() use($method) { return $this->getXmlResponse($method); };
                $getIdealResponse = function() { return $this->getIdealResponse(); };
                $actions = [
                    'eps' => $getXmlResponse,
                    'giropay' => $getXmlResponse,
                    'sofortbanking' => $getXmlResponse,
                    'bancontact' => $getXmlResponse,
                    'ideal' => $getIdealResponse,
                ];
                $executor = $registry->newExecutorForPaymentAbbreviations();
                return $executor->execute($actions, $method->getShortName());
            } catch (\Exception $e) {
                error_log(__METHOD__ . ' ' . __LINE__ . ' ' . $e->getMessage());
                return new EmptyDecoder();
            }
        }
        error_log(__METHOD__ . ' ' . __LINE__);
        return new EmptyDecoder();
    }

    private function getXmlResponse(PaymentMethodFQCN $methodFQCN)
    {
        if (!$this->environment->hasQueryParameter('eppresponse')) {
            error_log(__METHOD__ . ' ' . __LINE__);
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