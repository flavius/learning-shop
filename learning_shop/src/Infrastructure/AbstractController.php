<?php


namespace App\Infrastructure;

use App\PaymentSDK\PaymentGatewayConfig;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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