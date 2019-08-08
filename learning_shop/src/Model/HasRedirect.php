<?php


namespace App\Model;


interface HasRedirect
{
    public function getRedirect(\Wirecard\PaymentSdk\Entity\Redirect $param);
}