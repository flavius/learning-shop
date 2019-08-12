<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\ValueObject;

trait SingleValueObject
{
    private $value;

    private function checkValueType($otherValue): bool
    {
        if (!is_a($this, get_class($this))) {
            return false;
        }
        return true;
    }

    public function equals(ValueObject $other): bool
    {
        if (!$this->checkValueType($other)) {
            return false;
        }
        /** @var $other SingleValueObject */
        if($this->value instanceof ValueObject) {
            if($other->value instanceof ValueObject) {
                return $this->value->equals($other);// true true
            } else {
                return $this->value->value == $other->value;// true false
            }
        } else {
            if($other->value instanceof ValueObject) {
                return $this->value == $other->value->value;// false true
            } else {
                return $this->value == $other->value;// false false
            }
        }
    }

    public function asString(): string {
        return (string)$this->value;
    }
}