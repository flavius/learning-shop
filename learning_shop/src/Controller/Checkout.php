<?php


namespace App\Controller;


use App\Infrastructure\AbstractController;

use App\Model\Eps;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Wirecard\PaymentSdk\Entity\Amount;
use Wirecard\PaymentSdk\Entity\BankAccount;
use Wirecard\PaymentSdk\Entity\Basket;
use Wirecard\PaymentSdk\Entity\Item;
use Wirecard\PaymentSdk\Entity\Redirect;
use Wirecard\PaymentSdk\Response\FailureResponse;
use Wirecard\PaymentSdk\Response\InteractionResponse;
use Wirecard\PaymentSdk\Transaction\Transaction;
use Wirecard\PaymentSdk\TransactionService;

use Wirecard\PaymentSdk\Transaction\EpsTransaction;

class Checkout extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index()
    {
        phpinfo(); exit;
        return $this->render('index/checkout.html.twig', []);
    }

    /**
     * @Route("/send_payment")
     */
    public function send_payment()
    {
        $config = $this->getWirecardConfig();
        $paymentGateway = $config->newPaymentGateway();
        $type = Eps::class;
        $transaction = $paymentGateway->getTransaction($type);



        $config = $this->getWirecardConfig();
        $amount = new Amount(18.4, 'EUR');

        $redirect = new Redirect(
            $this->generateUrl('app_notification_success'),
            $this->generateUrl('app_notification_cancel'),
            $this->generateUrl('app_notification_failure')
        );

        $bankAccount = new BankAccount();
        $bankAccount->setBic("BWFBATW1XXX");
        $bankAccount->setIban("NL13TEST0123456789");

        $basket = new Basket();
        $item = new Item('hello', $amount, 2);
        $basket->add($item);

        $transaction = new EpsTransaction();
        $transaction->setAmount($amount);
        $transaction->setRedirect($redirect);
        $transaction->setBankAccount($bankAccount);
        $transaction->setDescriptor('eps pay 123');

        $transaction->setBasket($basket);

        $transactionService = new TransactionService($config);

        //$transactionService->car

        $response = $transactionService->pay($transaction);
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