<?php


namespace App\PaymentSDK;


use Wirecard\PaymentSdk\Response\Response as LegacyResponse;

interface ResponseDecoder
{

    public function getLegacyResponse(): LegacyResponse;

}