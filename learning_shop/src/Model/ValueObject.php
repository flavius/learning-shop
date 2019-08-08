<?php


namespace App\Model;


interface ValueObject
{

    public function equals(ValueObject $other) : bool;

}