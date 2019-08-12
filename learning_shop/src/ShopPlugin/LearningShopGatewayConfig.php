<?php
namespace App\ShopPlugin;

use App\PaymentSDK\PaymentGateway;
use App\PaymentSDK\PaymentGatewayConfig;

use App\PaymentSDK\PaymentMethod\EpsConfig;
use App\PaymentSDK\PaymentMethodConfig;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LearningShopGatewayConfig implements PaymentGatewayConfig
{

    /**
     * @var Router
     */
    private $router;

    private $paymentMethodsConfigs = [];

    private $paymentConfigs = [];

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->paymentMethodsConfigs = [
            EpsConfig::class => function () {
                return new LearningEpsConfig($this);
            },
        ];
    }

    public function newGateway(): PaymentGateway
    {
        return new PaymentGateway($this);
    }

    public function getSuccessUrl()
    {
        return $this->router->generate('app_notification_success', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getCancelUrl()
    {
        return $this->router->generate('app_notification_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getFailureUrl()
    {
        return $this->router->generate('app_notification_failure', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @return PaymentMethodConfig[]
     */
    public function getPaymentConfigs()
    {
        if (!$this->paymentConfigs) {
            foreach ($this->paymentMethodsConfigs as $paymentConfigType => $factory) {
                if (!isset($this->paymentConfigs[$paymentConfigType])) {
                    $name = new PaymentMethodFQCN($paymentConfigType);
                    $this->paymentConfigs[$name->asString()] = $factory();
                }
            }
        }
        return $this->paymentConfigs;
    }

    public function getPaymentMethodConfig(PaymentMethodFQCN $interfaceName): PaymentMethodConfig
    {
        return $this->getPaymentConfigs()[$interfaceName->asString()];
    }

    public function getLegacyConfig(PaymentMethodConfig $paymentMethodConfig): \Wirecard\PaymentSdk\Config\Config
    {
        $baseUrl = $paymentMethodConfig->getGatewayUrl();
        $httpUser = $paymentMethodConfig->getGatewayUsername();
        $httpPass = $paymentMethodConfig->getGatewayPassword();
        $config = new \Wirecard\PaymentSdk\Config\Config($baseUrl, $httpUser, $httpPass, 'EUR');
        $maid = $paymentMethodConfig->getMaid()->asString();
        $secret = $paymentMethodConfig->getGatewaySecret()->asString();

        $legacyMethodConfig = new \Wirecard\PaymentSdk\Config\PaymentMethodConfig(\Wirecard\PaymentSdk\Transaction\EpsTransaction::NAME, $maid, $secret);
        $config->add($legacyMethodConfig);
        return $config;
    }
}