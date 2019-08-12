<?php


namespace App\PaymentSDK;


interface ValueObject
{
    public function equals(ValueObject $other) : bool;
}