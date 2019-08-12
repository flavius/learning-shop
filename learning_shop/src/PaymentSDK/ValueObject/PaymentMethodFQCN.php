<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\PaymentMethod\EpsConfig;
use App\PaymentSDK\PaymentMethod\EpsTransaction;
use App\PaymentSDK\ValueObject;

class PaymentMethodFQCN implements ValueObject
{
    use SingleValueObject;

    public function __construct(string $name)
    {
        $name = $this->mapThroughConfigs($name);
        $validNames = [
            EpsTransaction::class,
        ];
        if (!in_array($name, $validNames)) {
            throw new \DomainException('Invalid paymend method FQCN: ' . $name);
        }
        $this->value = $name;
    }

    private function mapThroughConfigs(string $name): string
    {
        $configMaps = [
            EpsConfig::class => EpsTransaction::class,
        ];
        if(isset($configMaps[$name])) {
            return $configMaps[$name];
        }
        return $name;
    }
}