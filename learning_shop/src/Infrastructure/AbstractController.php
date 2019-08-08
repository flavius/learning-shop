<?php


namespace App\Infrastructure;


use App\Model\HasBankAccount;
use App\Model\HasRedirect;
use App\Model\PaymentGateway;
use App\Model\PaymentGatewayConfig;
use App\Model\PaymentMethod;
use App\ShopPlugin\LearningShopConfig;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Wirecard\PaymentSdk\Config;
use Wirecard\PaymentSdk\Config\PaymentMethodConfig;
use Wirecard\PaymentSdk\Entity\Redirect;
use Wirecard\PaymentSdk\Transaction\EpsTransaction;
use Wirecard\PaymentSdk\Transaction\Transaction;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @var LearningShopConfig
     */
    private $config;

    protected function getWirecardConfig() : PaymentGatewayConfig {
        if(!isset($this->config)) {
           $this->config = new LearningShopConfig($this->get('router'));
        }
        return $this->config;
    }

    protected function generateUrl(string $route, array $parameters = [], int $referenceType = 0): string
    {
        $this->get('router')->getContext()->setHost($_SERVER['HTTP_HOST']);
        return parent::generateUrl($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }


}