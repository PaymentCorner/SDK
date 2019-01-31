<?php

class Rates
{

    /**
     * @return mixed
     */
    public function getCurrencyToBuy()
    {
        return $this->currency_to_buy;
    }

    /**
     * @param mixed $currency_to_buy
     * @throws PaymentCornerExceptions
     */
    public function setCurrencyToBuy($currency_to_buy)
    {
        if ((strtoupper($currency_to_buy) != $currency_to_buy || strlen($currency_to_buy) != 3)) {
            throw new PaymentCornerExceptions('currency_to_buy should be in ISO 4217 format.');
        }
        $this->currency_to_buy = $currency_to_buy;
    }

    /**
     * @return mixed
     */
    public function getCurrencyToSell()
    {
        return $this->currency_to_sell;
    }

    /**
     * @param mixed $currency_to_sell
     */
    public function setCurrencyToSell($currency_to_sell)
    {
        if ((strtoupper($currency_to_sell) != $currency_to_sell || strlen($currency_to_sell) != 3)) {
            throw new PaymentCornerExceptions('currency to sell should be in ISO 4217 format.');
        }
        $this->currency_to_sell = $currency_to_sell;
    }

    /**
     * @return mixed
     */
    public function getSideOfFxTx()
    {
        return $this->side_of_fx_tx;
    }

    /**
     * @param mixed $side_of_fx_tx
     * @throws PaymentCornerExceptions
     */
    public function setSideOfFxTx($side_of_fx_tx)
    {

        if (!in_array($side_of_fx_tx, array('buy', 'sell'))) {
            throw new PaymentCornerExceptions('side_of_fx_tx should be in range: sell, buy', 412);
        }
        $this->side_of_fx_tx = $side_of_fx_tx;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @throws PaymentCornerExceptions
     */
    public function setAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new PaymentCornerExceptions('amount can only be numeric', 412);
        }
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getFxTxDate()
    {
        return $this->fx_tx_date;
    }

    /**
     * @param mixed $fx_tx_date
     * @throws PaymentCornerExceptions
     */
    public function setFxTxDate($fx_tx_date)
    {
        if (!$this->validateDate($fx_tx_date)) {
            throw new PaymentCornerExceptions('fx_tx_date should be in ISO 8601 format', 412);
        }
        $this->fx_tx_date = $fx_tx_date;
    }

    /**
     * @return mixed
     */
    public function getCurrencyPair()
    {
        return $this->currency_pair;
    }

    /**
     * @param mixed $currency_pair
     * @throws PaymentCornerExceptions
     */
    public function setCurrencyPair($currency_pair)
    {
        if ((strtoupper($currency_pair) != $currency_pair || strlen($currency_pair) != 6)) {
            throw new PaymentCornerExceptions('currency_pair should be two ISO 4217 format concatenated.');
        }
        $this->currency_pair = $currency_pair;
    }

    private function validateDate($date, $format = 'YYYY-MM-DD')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }


}