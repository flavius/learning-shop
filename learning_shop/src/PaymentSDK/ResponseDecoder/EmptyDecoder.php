<?php


namespace App\PaymentSDK\ResponseDecoder;


use App\PaymentSDK\PaymentMethodConfig;
use App\PaymentSDK\ResponseDecoder;
use Wirecard\PaymentSdk\Response\FailureResponse;
use Wirecard\PaymentSdk\Response\Response as LegacyResponse;

class EmptyDecoder implements ResponseDecoder
{

    public function getLegacyResponse(): LegacyResponse
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<payment xmlns="http://www.elastic-payments.com/schema/payment" xmlns:ns2="http://www.elastic-payments.com/schema/epa/transaction">
 <transaction-state>failed</transaction-state>
 <statuses>
  <status code="999.9999" description="Could not decode response" severity="error" />
 </statuses>
</payment>');
        return new FailureResponse($xml);
    }
}