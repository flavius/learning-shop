<?php


namespace App\PaymentSDK;


use App\PaymentSDK\ValueObject\PaymentMethodFQCN;
use Wirecard\PaymentSdk\Transaction\EpsTransaction as LegacyEpsTransaction;
use Wirecard\PaymentSdk\Transaction\GiropayTransaction as LegacyGiropayTransaction;
use Wirecard\PaymentSdk\Transaction\IdealTransaction as LegacyIdealTransaction;

class PaymentMethodRegistry
{
    /**
     * @var array
     *
     * Currently based on legacy names for convenience.
     */
    private $codes = [
        LegacyEpsTransaction::NAME,
        LegacyGiropayTransaction::NAME,
        LegacyIdealTransaction::NAME,
    ];

    /**
     * @return PaymentMethodFQCN[]
     */
    public final function getAllFQCNs() {
        $names = [];
        foreach ($this->codes as $code) {
            $names[$code] = new PaymentMethodFQCN($code);
        }
        return $names;
    }
}