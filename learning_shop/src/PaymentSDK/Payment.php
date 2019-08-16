<?php


namespace App\PaymentSDK;


interface Payment
{

    public function getValuable(): Valuable;

    public function getPaymentMethod(): PaymentMethod;

}