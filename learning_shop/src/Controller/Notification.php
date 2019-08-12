<?php


namespace App\Controller;


use App\Infrastructure\AbstractController;
use App\PaymentSDK\PaymentMethod\EpsTransaction;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use App\ShopPlugin\LearningShopGatewayConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Wirecard\PaymentSdk\Mapper\ResponseMapper;

class Notification extends AbstractController
{
    /**
     * @Route("/success")
     */
    public function success(Request $request)
    {
        //POST: eppresponse, locale, psp_name="elastic-payments"
        $eppresponse = $request->get('eppresponse');
        $name = $request->query->get('name');
        $paymentMethod = new PaymentMethodFQCN($name);

        $config = new LearningShopGatewayConfig($this->get('router'));
        $gateway = $config->newGateway();
        $response = $gateway->decodeResponse($eppresponse, $paymentMethod);

        $details = $response->getTransactionDetails()->getAsHtml(['table_id' => 'transaction_details']);
        return $this->render('index/transaction_details.html.twig', ['transaction_details' => $details]);
    }

    /**
     * @Route("/cancel")
     */
    public function cancel()
    {
        echo __METHOD__; exit;
    }

    /**
     * @Route("/failure")
     */
    public function failure()
    {
        echo __METHOD__; exit;
    }

}