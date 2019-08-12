<?php


namespace App\PaymentSDK;


interface HasPluginUrlEndpoints
{
    public function getSuccessUrl();

    public function getCancelUrl();

    public function getFailureUrl();

}