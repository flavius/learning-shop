<?php


namespace App\Model;


use Psr\Container\ContainerInterface;
use Wirecard\PaymentSdk\Entity\Redirect;

class PaymentGateway
{

    /**
     * @var PaymentGatewayConfig
     */
    private $config;

    /**
     * @var ContainerInterface
     */
    private $dic;

    public function __construct(PaymentGatewayConfig $config, ContainerInterface $dic)
    {
        $this->config = $config;
        $this->dic = $dic;
    }

    private function newTransaction(string $type, $ctorArgs = []) : PaymentMethod
    {
        if(!class_exists($type)) {
            throw new \RuntimeException('Class does not exist');
        }

        return new $type(...$ctorArgs);
    }

    public function getTransaction(string $type, $ctorArgs = []) {
        $transaction = $this->newTransaction($type, $ctorArgs);
        if($transaction instanceof HasRedirect) {
//            $transaction->getRedirect(new Redirect(
//                $this->config->getSuccessUrl(),
//                $this->config->getCancelUrl(),
//                $this->config->getFailureUrl(),
//                ));
        }

        if($transaction instanceof HasBankAccount) {
            $transaction->setBankAccount($this->config->getBankAccount());
        }

        return $transaction;
    }

}