<?php


namespace App\Controller;


use App\Infrastructure\AbstractController;

use App\PaymentSDK\PaymentMethod\EpsTransaction;
use App\PaymentSDK\Valuable\UnnamedValuable;
use App\PaymentSDK\ValueObject\Amount;
use App\PaymentSDK\ValueObject\Currency;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use App\ShopPlugin\LearningShopGatewayConfig;
use Symfony\Component\Routing\Annotation\Route;
use Wirecard\PaymentSdk\Response\InteractionResponse;

class Checkout extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('index/checkout.html.twig', []);
    }

    /**
     * @Route("/send_payment")
     */
    public function send_payment()
    {
        $config = new LearningShopGatewayConfig($this->get('router'));
        $gateway = $config->newGateway();

        $valuable = new UnnamedValuable(new Amount(18.4, new Currency('EUR')));

        $response = $gateway->pay($valuable, new PaymentMethodFQCN(EpsTransaction::class));

        if ($response instanceof InteractionResponse) {
            //echo($response->getRedirectUrl());
            header('Location: ' . $response->getRedirectUrl());
            exit;
        }
        echo '<pre>';
        var_dump($response);

        exit;
    }




}