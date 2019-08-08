<?php


namespace App\ShopPlugin;


use App\Model\Currency;
use App\Model\CurrencyManager;
use App\Model\PaymentGateway;
use App\Model\PaymentGatewayConfig;
use App\Model\ValueObject\BankAccount;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Wirecard\PaymentSdk\Config\PaymentMethodConfig;
use Wirecard\PaymentSdk\Entity\Redirect;
use Wirecard\PaymentSdk\Transaction\EpsTransaction;

use Wirecard\PaymentSdk\Config;

/**
 * Class LearningShopConfig
 * @package App\ShopPlugin
 *
 * This would fetch its configuration from the DB.
 */
class LearningShopConfig implements PaymentGatewayConfig
{

    /**
     * @var Router
     */
    private $router;

    private $legacySdkConfig;

    /**
     * @var CurrencyManager
     */
    private $currencyManager;
    /**
     * @var ContainerInterface
     */
    private $dic;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->legacySdkConfig = $this->getLegacyConfig();
        //The value 'EUR' would be fetch from the DB.
        $this->currencyManager = new CurrencyManager(new Currency('EUR'));

        $builder = new ContainerBuilder();

        $builder->addDefinitions([
            PaymentGatewayConfig::class => $this,
            BankAccount::class => function(ContainerInterface $c) { return $c->get(PaymentGatewayConfig::class)->getBankAccount(); },
        ]);

        $this->dic = $builder->build();

    }

    public function getSuccessUrl()
    {
        return $this->router->generate('app_notification_success', [],  UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getCancelUrl()
    {
        return $this->router->generate('app_notification_cancel', [],  UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getFailureUrl()
    {
        return $this->router->generate('app_notification_failure', [],  UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @return Config\Config
     *
     * This would fetch the settings from the shop system (e.g. from the DB).
     */
    private function getLegacyConfig() : Config\Config {
        $baseUrl = 'https://api-test.wirecard.com';
        $httpUser = '16390-testing';
        $httpPass = '3!3013=D3fD8X7';

        $config = new Config\Config($baseUrl, $httpUser, $httpPass, $this->currencyManager->getPrimaryCurrency()->getAbbreviation());

        $epsMAID = '1f629760-1a66-4f83-a6b4-6a35620b4a6d';
        $epsSecret = '20c6a95c-e39b-4e6a-971f-52cfb347d359';
        $epsConfig = new PaymentMethodConfig(EpsTransaction::NAME, $epsMAID, $epsSecret);
        $config->add($epsConfig);

        return $config;
    }

    public function newPaymentGateway() : PaymentGateway
    {
        return new PaymentGateway($this, $this->dic);
    }

    public function getBankAccount(): BankAccount
    {
        //TODO: this would come from the DB and the instance would be cached
        return new BankAccount('NL13TEST0123456789', 'BWFBATW1XXX');
    }
}