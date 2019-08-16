<?php


namespace App\PaymentSDK;


use App\PaymentSDK\PaymentMethod\EpsTransaction;
use App\PaymentSDK\PaymentMethod\GiropayTransaction;
use App\PaymentSDK\PaymentMethod\IdealTransaction;
use App\PaymentSDK\PaymentMethod\SofortTransaction;
use App\PaymentSDK\ValueObject\PaymentMethodFQCN;

class PaymentMethodRegistry
{

    /**
     * @var array
     *
     * When creating a new payment method, you have to add it here
     */
    private $validNames = [
        EpsTransaction::class,
        GiropayTransaction::class,
        IdealTransaction::class,
        SofortTransaction::class,
    ];

    /**
     * @var array
     *
     * Maps payment config interface name to factory callable for config object for the payment
     */
    private $configFactories = [];

    /**
     * @var PaymentMethodConfig[]
     *
     * Maps payment method class name to config object for the payment method
     */
    private $configs = [];

    /**
     * @var array
     *
     * Maps abbreviations of pyment method to payment method class name.
     */
    private $reverseAbbreviations = [];

    /**
     * PaymentMethodRegistry constructor.
     * @param PaymentGatewayConfig $config
     *
     * @todo limit the number of payment methods based on config
     */
    public function __construct(PaymentGatewayConfig $config, $paymentConfigFactories)
    {
        $this->configFactories = $this->createPaymentMethodFactories($paymentConfigFactories);
        foreach ($this->configFactories as $configInterface => $factory) {
            /** @var PaymentMethodConfig $config */
            $config = $factory();
            $abbrev = $config->getAbbreviation();
            $paymentMethodClass = $config->getPaymentMethodFQCN();
            $this->reverseAbbreviations[$abbrev] = $paymentMethodClass;
            $this->configs[$paymentMethodClass] = $config;
        }
        if (count($paymentConfigFactories) != count($this->validNames)) {
            $desiredPaymentMethods = $this->validNames;
            $providedPaymentMethods = array_values($this->reverseAbbreviations);
            $missingMethods = array_diff($desiredPaymentMethods, $providedPaymentMethods);
            if ($missingMethods) {
                throw new \RuntimeException("Config factories not provided for the payment methods: " . implode(', ', $missingMethods));
            }
            throw new \RuntimeException("Config factories not provided for all payment methods");
        }
        //echo '<pre>';var_dump($this->configFactories);var_dump($this->configs);var_dump($this->reverseAbbreviations);exit;
    }

    private function createPaymentMethodFactories($paymentConfigFactories)
    {
        $configFactories = [];
        foreach ($paymentConfigFactories as $paymentInterfaceName => $factory) {
            if (!interface_exists($paymentInterfaceName)) {//more optimal than reflection, because it looks up in the class table directly
                throw new \RuntimeException("Interface $paymentInterfaceName does not exist");
            }
            try {
                $reflection = new \ReflectionClass($paymentInterfaceName);
            } catch (\ReflectionException $e) {
                //should never occur
            }
            if (!$reflection->implementsInterface(PaymentMethodConfig::class)) {
                throw new \RuntimeException("Interface $paymentInterfaceName is not a configuration for a payment method");
            }
            unset($reflection);//TODO: measure performance impact
            $configFactories[$paymentInterfaceName] = $factory;
        }
        return $configFactories;
    }

    /**
     * @return PaymentMethodFQCN[]
     */
    public function getAllFQCNs()
    {
        $names = [];
        foreach (array_keys($this->reverseAbbreviations) as $code) {
            $names[$code] = new PaymentMethodFQCN($code, $this);
        }
        return $names;
    }

    public function getValidNames()
    {
        return $this->validNames;
    }

    public function getShortNamesMap()
    {
        return array_flip($this->reverseAbbreviations);
    }

    /**
     * @return array
     *
     * @deprecated
     *
     * @todo this is here only for the value objects PaymentMethodFQCN, which shouldn't be used at all
     * @todo remove
     */
    public function getConfigMap()
    {
        return array_map(function (PaymentMethodConfig $config) {
            return $config->getPaymentMethodFQCN();
        }, $this->configs);
    }

    public function newExecutorForConfigs(): ExhaustiveExecutor
    {
        return new ExhaustiveExecutor(array_keys($this->configs));
    }

    public function newExecutorForPaymentMethods(): ExhaustiveExecutor
    {
        return new ExhaustiveExecutor($this->validNames);
    }

    public function newExecutorForPaymentAbbreviations(): ExhaustiveExecutor
    {
        return new ExhaustiveExecutor(array_keys($this->reverseAbbreviations));
    }

    /**
     * @return PaymentMethodConfig[]
     */
    public function getPaymentConfigs()
    {
        return $this->configs;
    }

    public function isAbbreviation(string $name)
    {
        $abbrevs = array_keys($this->reverseAbbreviations);
        return in_array($name, $abbrevs);
    }

    public function resolveAbbreviation(string $name)
    {
        if (!$this->isAbbreviation($name)) {
            throw new \RuntimeException("Invalid abbreviation, before calling " . __METHOD__ . " check with method " . __CLASS__ . "isAbbreviation");
        }
        return $this->reverseAbbreviations[$name];
    }

    public function getAbbreviation(string $name)
    {
        return array_flip($this->reverseAbbreviations)[$name];
    }

    public function getPaymentMethod(PaymentMethodFQCN $method_name): PaymentMethod
    {
        $name = $method_name->asString();
        assert(isset($this->configs[$name]));
        return $this->configs[$name]->getPaymentMethod();
    }
}