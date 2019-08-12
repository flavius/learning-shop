<?php


namespace App\PaymentSDK;

use App\PaymentSDK\ValueObject\Amount;

/**
 * Interface Valuable
 * @package App\PaymentSDK
 *
 * Something which has a value in terms of value.
 *
 * Alternative names: Amountable, Payable, Buyable, Sellable
 */
interface Valuable
{
    public function getAmount(): Amount;
}