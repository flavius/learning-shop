<?php


namespace App\PaymentSDK\ValueObject;


use App\PaymentSDK\PaymentMethod\EpsConfig;
use App\PaymentSDK\PaymentMethod\EpsTransaction;
use App\PaymentSDK\ValueObject;

class PaymentMethodFQCN implements ValueObject
{
    use SingleValueObject;

    /**
     * @var array
     *
     * Based on the legacy names (at least for now).
     */
    private $shortNames = [
        EpsTransaction::class => \Wirecard\PaymentSdk\Transaction\EpsTransaction::NAME,
    ];

    public function __construct(string $name)
    {
        $name = $this->mapThroughConfigs($name);
        $name = $this->mapThroughLegacy($name);
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
        if (isset($configMaps[$name])) {
            return $configMaps[$name];
        }
        return $name;
    }

    private function mapThroughLegacy(string $name): string
    {
        $legacyMap = array_flip($this->shortNames);
        if (isset($legacyMap[$name])) {
            return $legacyMap[$name];
        }
        return $name;
    }

    public function getShortName(): string
    {
        if (!isset($this->shortNames[$this->value])) {
            throw new \RuntimeException('Short name not registered for transaction class ' . $this->value);
        }
        return $this->shortNames[$this->value];
    }
}