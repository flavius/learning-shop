<?php


namespace App\Infrastructure;


use App\Model\ValueObject;

trait DoubleValueObject
{

    private $value1;
    private $value2;

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
        /** @var $other DoubleValueObject */
        return $this->value1 == $other->value && $this->value2 == $other->value2;
    }

}