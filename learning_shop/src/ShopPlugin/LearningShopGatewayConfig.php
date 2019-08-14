<?php
namespace App\ShopPlugin;

use App\PaymentSDK\PaymentGateway;
use App\PaymentSDK\PaymentGatewayConfig;

use App\PaymentSDK\PaymentMethod\EpsConfig;
use App\PaymentSDK\PaymentMethod\GiropayConfig;
use App\PaymentSDK\PaymentMethod\IdealConfig;
use App\PaymentSDK\PaymentMethodConfig;
use App\PaymentSDK\PaymentMethodRegistry;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LearningShopGatewayConfig implements PaymentGatewayConfig
{

    /**
     * @var Router
     */
    private $router;

    private $paymentMethodRegistry;

    /**
     * LearningShopGatewayConfig constructor.
     * @param Router $router
     *
     * This would also get the list of active payment methods from the DB and create factories only for them
     */
    public function __construct(Router $router)
    {
        $factories = [//TODO: before version 7.1 (excluding 7.1), $this has to be passed in explicitly
            EpsConfig::class => function () { return new LearningEpsConfig($this); },
            GiropayConfig::class => function () { return new LearningGiropayConfig($this); },
            IdealConfig::class => function () { return new LearningIdealConfig($this); },
        ];
        $this->paymentMethodRegistry = new PaymentMethodRegistry($this, $factories);
        $this->router = $router;
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
        return $this->paymentMethodRegistry->getPaymentConfigs();
        /*if (!$this->paymentConfigs) {
            $executor = $this->paymentMethodRegistry->newExecutorForConfigs();
            foreach ($this->paymentMethodsConfigs as $paymentConfigType => $factory) {
                if (!isset($this->paymentConfigs[$paymentConfigType])) {
                    $name = new PaymentMethodFQCN($paymentConfigType, $this->paymentMethodRegistry);
                    $this->paymentConfigs[$name->asString()] = $executor->execute($this->paymentMethodsConfigs, $paymentConfigType);
                }
            }
        }
        return $this->paymentConfigs;*/
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

        $legacyMethodConfig = new \Wirecard\PaymentSdk\Config\PaymentMethodConfig($paymentMethodConfig->getAbbreviation(), $maid, $secret);
        $config->add($legacyMethodConfig);
        return $config;
    }

    public function getPaymentMethodsRegistry(): PaymentMethodRegistry
    {
        return $this->paymentMethodRegistry;
    }
}