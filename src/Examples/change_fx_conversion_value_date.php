<?php


require_once __DIR__ . '../../vendor/autoload.php';

/**
 *Required Parameters
 * path | new_date_fx_tx
 */

try {
    $paymentCorner = new PaymentCorner('user@domain.com', 'password', 'xxxxx-xxxxx-xxxxx-xxxx-xxxxx', false);
    $transaction = new Transactions();
    $transaction->setPath('a634d8c2-f520-4cba-985c-77dc1e0cc9af');
    $transaction->setNewDateFxTx('2019-02-3');
    $paymentCorner->changeFxConversionValueDate($transaction);
} catch (PaymentCornerExceptions $exception) {
    echo $exception->getMessage();

}