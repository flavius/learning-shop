<?php


namespace App\Controller;


use App\Infrastructure\AbstractController;

use App\PaymentSDK\PaymentMethod\EpsTransaction;
use App\PaymentSDK\PaymentMethodRegistry;
use App\PaymentSDK\RequestEnvironment;
use App\PaymentSDK\Valuable\NamedValuable;
use App\PaymentSDK\Valuable\UnnamedValuable;
use App\PaymentSDK\ValueObject\Amount;
use App\PaymentSDK\ValueObject\Currency;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use App\ShopPlugin\LearningShopGatewayConfig;
use Symfony\Component\Routing\Annotation\Route;
use Wirecard\PaymentSdk\Response\InteractionResponse;
use Symfony\Component\HttpFoundation\Request;

class Checkout extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index()
    {
        $registry = new PaymentMethodRegistry();
        $payment_methods = [];
        foreach($registry->getAllFQCNs() as $name => $fqcn) {
            $payment_methods[$name] = $name;//TODO: here UI thing (like transaction, if needed by the shop)
        }

        return $this->render('index/checkout.html.twig', ['payment_methods' => $payment_methods]);
    }

    /**
     * @Route("/send_payment")
     */
    public function send_payment(Request $request)
    {
        $config = new LearningShopGatewayConfig($this->get('router'));
        $gateway = $config->newGateway();
        $payment_method = $request->get('payment_method');
        $descriptor = $request->get('descriptor', '');
        $amount = new Amount(18.4, new Currency('EUR'));
        if($descriptor) {
            $valuable = new NamedValuable($amount, $descriptor);
        } else {
            $valuable = new UnnamedValuable($amount);
        }

        $response = $gateway->pay($valuable, new PaymentMethodFQCN($payment_method));

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