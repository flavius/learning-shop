<?php


namespace App\Infrastructure;


use App\Model\ValueObject;

trait SingleValueObject
{

    private $value;

    private function checkValueType($otherValue) : bool {
        if(!is_a($this, get_class($this))) {
            //if(!($otherValue instanceof self::class)) {
            return false;
        }
        return true;
    }

    public function equals(ValueObject $other) : bool
    {
        if(!$this->checkValueType($other)) {
            return false;
        }
        /** @var $other SingleValueObject */
        return $this->value == $other->value;
    }
}