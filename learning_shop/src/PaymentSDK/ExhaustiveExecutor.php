<?php


namespace App\PaymentSDK;


class ExhaustiveExecutor
{

    private $exhaustiveValidKeys;

    public function __construct($exhaustiveValidKeys)
    {
        $this->exhaustiveValidKeys = $exhaustiveValidKeys;
    }

    public function execute($strategies, $selector)
    {
        $desiredKeys = $this->exhaustiveValidKeys;
        $providedKeys = array_keys($strategies);
        if (!in_array($selector, $providedKeys)) {
            throw new \RuntimeException("Selector must be one of the provided values: " . implode(', ', $providedKeys) . '. Provided: ' . $selector);
        }
        $this->checkIntersection($desiredKeys, $providedKeys);
        return $strategies[$selector]();
    }

    private function checkIntersection($desiredKeys, $providedKeys)
    {
        $additionalDesired = array_diff($desiredKeys, $providedKeys);
        if ($additionalDesired) {
            throw new \RuntimeException("Missing strategies for: " . implode(', ', $additionalDesired));
        }
        $additionalProvided = array_diff($providedKeys, $desiredKeys);
        if ($additionalProvided) {
            throw new \RuntimeException("Provided more strategies than required: " . implode(', ', $additionalProvided));
        }
    }

}