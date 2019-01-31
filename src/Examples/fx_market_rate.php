<?php

require_once __DIR__ . '../../vendor/autoload.php';

/**
 *Required Parameters
 * currency_pair
 */

try {
    $paymentCorner = new PaymentCorner('user@domain.com', 'password', 'xxxxx-xxxxx-xxxxx-xxxx-xxxxx', false);
    $rates = new Rates();
    $rates->setCurrencyPair('USDGBP');
    $paymentCorner->fxMarketRate($rates);
} catch (PaymentCornerExceptions $exception) {
    echo $exception->getMessage();

}

