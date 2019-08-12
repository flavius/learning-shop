<?php


namespace App\Valuable;

/**
 * Interface NumericValueObject
 * @package App\Valuable
 *
 * The reason we don't offer the possibility of retrieving the actual number is that some numeric values (like amounts)
 * are not interoperable, e.g. you cannot compare an EUR amount to an USD amount without an exchange rate.
 */
interface NumericValueObject
{
    public function multiplyBy($multiplier): NumericValueObject;

}