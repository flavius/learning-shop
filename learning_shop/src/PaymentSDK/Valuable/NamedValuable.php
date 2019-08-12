<?php


namespace App\PaymentSDK\Valuable;


use App\PaymentSDK\HasShortDescription;
use App\PaymentSDK\ValueObject\Amount;

class NamedValuable extends UnnamedValuable implements HasShortDescription
{

    /**
     * @var string
     */
    private $description;

    public function __construct(Amount $amount, string $description)
    {
        if (!trim($description)) {
            throw new \DomainException('Description cannot be empty');
        }
        parent::__construct($amount);
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}