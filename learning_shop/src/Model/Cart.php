<?php


namespace App\Model;


use Wirecard\PaymentSdk\Entity\Amount;
use Wirecard\PaymentSdk\Entity\Basket;
use Wirecard\PaymentSdk\Entity\Item;

class Cart implements Valuable
{

    /**
     * @var Basket
     */
    private $basket;

    /**
     * @var float
     */
    private $total = 0;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function addItem(Item $item)
    {
        $this->basket->add($item);
        $this->total += $item->getPrice()->getValue() * $item->getQuantity();
    }

    public function getAmount(): Amount
    {
        return new Amount($this->total, 'EUR');
    }
}