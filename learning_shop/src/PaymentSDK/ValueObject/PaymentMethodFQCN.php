<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\PaymentMethodRegistry;
use App\PaymentSDK\ValueObject;

class PaymentMethodFQCN implements ValueObject
{
    use SingleValueObject;

    /**
     * @var array
     *
     * Based on the legacy names (at least for now).
     */
    private $abbreviation;

    public function __construct(string $name, PaymentMethodRegistry $registry)
    {
        if ($registry->isAbbreviation($name)) {
            $this->abbreviation = $name;
            $name = $registry->resolveAbbreviation($name);
        } else {
            $this->abbreviation = $registry->getAbbreviation($name);
        }
        $validNames = $registry->getValidNames();
        if (!in_array($name, $validNames)) {
            throw new \DomainException('Invalid paymend method FQCN: ' . $name);
        }
        $this->value = $name;
    }

    public function getShortName(): string
    {
        return $this->abbreviation;
    }
}