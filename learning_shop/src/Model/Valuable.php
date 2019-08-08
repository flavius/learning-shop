<?php


namespace App\Model;

use Wirecard\PaymentSdk\Entity\Amount;

/**
 * Interface Valuable
 * @package App\Model
 *
 * Something which has a value in terms of value.
 *
 * Alternative names: Amountable, Payable, Buyable, Sellable
 */
interface Valuable
{
    public function getAmount(): Amount;
}