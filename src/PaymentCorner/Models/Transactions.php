<?php


class Transactions
{
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
            throw new PaymentCornerExceptions('side_of_fx_tx can either be buy or sell', 412);
        }
        $this->side_of_fx_tx = ($side_of_fx_tx);
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
    public function getFxTxGtc()
    {
        return $this->fx_tx_gtc;
    }

    /**
     * @param mixed $fx_tx_gtc
     */
    public function setFxTxGtc($fx_tx_gtc)
    {
        if (is_bool($fx_tx_gtc)) {
            if (!$fx_tx_gtc) {
                throw new PaymentCornerExceptions('Should agree fx_tx_gtc terms and conditions');
            }
        } else {
            throw new PaymentCornerExceptions('fx_tx_gtc can only be boolean', 412);

        }
        $this->fx_tx_gtc = $fx_tx_gtc;
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
    public function getAmountToBuy()
    {
        return $this->amount_to_buy;
    }

    /**
     * @param mixed $amount_to_buy
     * @throws PaymentCornerExceptions
     */
    public function setAmountToBuy($amount_to_buy)
    {
        if (!is_numeric($amount_to_buy)) {
            throw new PaymentCornerExceptions('amount_to_buy can only be numeric');
        }
        $this->amount_to_buy = $amount_to_buy;
    }

    /**
     * @return mixed
     */
    public function getAmountToSell()
    {
        return $this->amount_to_sell;
    }

    /**
     * @param mixed $amount_to_sell
     * @throws PaymentCornerExceptions
     */
    public function setAmountToSell($amount_to_sell)
    {
        if (!is_numeric($amount_to_sell)) {
            throw new PaymentCornerExceptions('amount_to_sell can only be numeric.');
        }
        $this->amount_to_sell = $amount_to_sell;
    }

    /**
     * @return mixed
     */
    public function getFxTxUniqueId()
    {
        return $this->fx_tx_unique_id;
    }

    /**
     * @param mixed $fx_tx_unique_id
     */
    public function setFxTxUniqueId($fx_tx_unique_id)
    {
        $this->fx_tx_unique_id = $fx_tx_unique_id;
    }

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


    private function validateDate($date, $format = 'YYYY-MM-DD')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     */
    public function setRef($ref)
    {
        $ref = explode("-", $ref);
        if (!isset($ref[2]) || !isset($ref[1])) {
            throw new PaymentCornerExceptions('Invalid ref', 412);
        }
        $this->ref = $ref;
    }

    /**
     * @return mixed
     */
    public function getFxTxStatus()
    {
        return $this->fx_tx_status;
    }

    /**
     * @param mixed $fx_tx_status
     * @throws PaymentCornerExceptions
     */
    public function setFxTxStatus($fx_tx_status)
    {
        if (!in_array($fx_tx_status, array('Funds_to_receive', 'Funds_sent', 'Funds_received', 'FX_deal_settled', 'FX_deal_closed'))) {
            throw new PaymentCornerExceptions('fx_tx_status should be Funds_to_receive, Funds_sent, Funds_received, FX_deal_settled or FX_deal_closed', 412);
        }
        $this->fx_tx_status = $fx_tx_status;
    }

    /**
     * @return mixed
     */
    public function getFxTxId()
    {
        return $this->fx_tx_id;
    }

    /**
     * @param mixed $fx_tx_id
     */
    public function setFxTxId($fx_tx_id)
    {
        $this->fx_tx_id = $fx_tx_id;
    }

    /**
     * @return mixed
     */
    public function getTxFromFirst()
    {
        return $this->tx_from_first;
    }

    /**
     * @param mixed $tx_from_first
     * @throws PaymentCornerExceptions
     */
    public function setTxFromFirst($tx_from_first)
    {
        if (!$this->validateDate($tx_from_first)) {
            throw new PaymentCornerExceptions('tx_from_first should be in ISO 8601 format', 412);
        }
        $this->tx_from_first = $tx_from_first;
    }

    /**
     * @return mixed
     */
    public function getTxToLast()
    {
        return $this->tx_to_last;
    }

    /**
     * @param mixed $tx_to_last
     * @throws PaymentCornerExceptions
     */
    public function setTxToLast($tx_to_last)
    {
        if (!$this->validateDate($tx_to_last)) {
            throw new PaymentCornerExceptions('tx_to_last should be in ISO 8601 format', 412);
        }
        $this->tx_to_last = $tx_to_last;
    }

    /**
     * @return mixed
     */
    public function getTxTimeUpdateFirst()
    {
        return $this->tx_time_update_first;
    }

    /**
     * @param mixed $tx_time_update_first
     * @throws PaymentCornerExceptions
     */
    public function setTxTimeUpdateFirst($tx_time_update_first)
    {
        if (!$this->validateDate($tx_time_update_first)) {
            throw new PaymentCornerExceptions('tx_time_update_first should be in ISO 8601 format', 412);
        }
        $this->tx_time_update_first = $tx_time_update_first;
    }

    /**
     * @return mixed
     */
    public function getTxTimeUpdateLast()
    {
        return $this->tx_time_update_last;
    }

    /**
     * @param mixed $tx_time_update_last
     * @throws PaymentCornerExceptions
     */
    public function setTxTimeUpdateLast($tx_time_update_last)
    {
        if (!$this->validateDate($tx_time_update_last)) {
            throw new PaymentCornerExceptions('tx_time_update_last should be in ISO 8601 format', 412);
        }
        $this->tx_time_update_last = $tx_time_update_last;
    }

    /**
     * @return mixed
     */
    public function getTxDateFrom()
    {
        return $this->tx_date_from;
    }

    /**
     * @param mixed $tx_date_from
     * @throws PaymentCornerExceptions
     */
    public function setTxDateFrom($tx_date_from)
    {
        if (!$this->validateDate($tx_date_from)) {
            throw new PaymentCornerExceptions('tx_date_from should be in ISO 8601 format', 412);
        }
        $this->tx_date_from = $tx_date_from;
    }

    /**
     * @return mixed
     */
    public function getTxDateTo()
    {
        return $this->tx_date_to;
    }

    /**
     * @param mixed $tx_date_to
     * @throws PaymentCornerExceptions
     */
    public function setTxDateTo($tx_date_to)
    {
        if (!$this->validateDate($tx_date_to)) {
            throw new PaymentCornerExceptions('tx_date_to should be in ISO 8601 format', 412);
        }
        $this->tx_date_to = $tx_date_to;
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

    /**
     * @return mixed
     */
    public function getMinAmountToBuy()
    {
        return $this->min_amount_to_buy;
    }

    /**
     * @param mixed $min_amount_to_buy
     * @throws PaymentCornerExceptions
     */
    public function setMinAmountToBuy($min_amount_to_buy)
    {
        if (!is_numeric($min_amount_to_buy)) {
            throw new PaymentCornerExceptions('min_amount_to_buy can only be numeric', 412);
        }
        $this->min_amount_to_buy = $min_amount_to_buy;
    }

    /**
     * @return mixed
     */
    public function getMaxAmountToBuy()
    {
        return $this->max_amount_to_buy;
    }

    /**
     * @param mixed $max_amount_to_buy
     * @throws PaymentCornerExceptions
     */
    public function setMaxAmountToBuy($max_amount_to_buy)
    {
        if (!is_numeric($max_amount_to_buy)) {
            throw new PaymentCornerExceptions('max_amount_to_buy can only be numeric', 412);
        }
        $this->max_amount_to_buy = $max_amount_to_buy;
    }

    /**
     * @return mixed
     */
    public function getMinAmountToSell()
    {
        return $this->min_amount_to_sell;
    }

    /**
     * @param mixed $min_amount_to_sell
     * @throws PaymentCornerExceptions
     */
    public function setMinAmountToSell($min_amount_to_sell)
    {
        if (!is_numeric($min_amount_to_sell)) {
            throw new PaymentCornerExceptions('min_amount_to_sell can only be numeric', 412);
        }
        $this->min_amount_to_sell = $min_amount_to_sell;
    }

    /**
     * @return mixed
     */
    public function getMaxAmountToSell()
    {
        return $this->max_amount_to_sell;
    }

    /**
     * @param mixed $max_amount_to_sell
     * @throws PaymentCornerExceptions
     */
    public function setMaxAmountToSell($max_amount_to_sell)
    {
        if (!is_numeric($max_amount_to_sell)) {
            throw new PaymentCornerExceptions('min_amount_to_sell can only be numeric', 412);
        }
        $this->max_amount_to_sell = $max_amount_to_sell;
    }

    /**
     * @return mixed
     */
    public function getDateTxDebitFirst()
    {
        return $this->date_tx_debit_first;
    }

    /**
     * @param mixed $date_tx_debit_first
     * @throws PaymentCornerExceptions
     */
    public function setDateTxDebitFirst($date_tx_debit_first)
    {
        if (!$this->validateDate($date_tx_debit_first)) {
            throw new PaymentCornerExceptions('date_tx_debit_first should be in ISO 8601 format', 412);
        }
        $this->date_tx_debit_first = $date_tx_debit_first;
    }

    /**
     * @return mixed
     */
    public function getDateTxDebitLast()
    {
        return $this->date_tx_debit_last;
    }

    /**
     * @param mixed $date_tx_debit_last
     * @throws PaymentCornerExceptions
     */
    public function setDateTxDebitLast($date_tx_debit_last)
    {
        if (!$this->validateDate($date_tx_debit_last)) {
            throw new PaymentCornerExceptions('date_tx_debit_last should be in ISO 8601 format', 412);
        }
        $this->date_tx_debit_last = $date_tx_debit_last;
    }

    /**
     * @return mixed
     */
    public function getPageNb()
    {
        return $this->page_nb;
    }

    /**
     * @param mixed $page_nb
     * @throws PaymentCornerExceptions
     */
    public function setPageNb($page_nb)
    {
        if (!is_numeric($page_nb)) {
            throw new PaymentCornerExceptions('page_nb can only be numeric', 412);
        }
        $this->page_nb = $page_nb;
    }

    /**
     * @return mixed
     */
    public function getResultPerPage()
    {
        return $this->result_per_page;
    }

    /**
     * @param mixed $result_per_page
     * @throws PaymentCornerExceptions
     */
    public function setResultPerPage($result_per_page)
    {
        if (!is_numeric($result_per_page)) {
            throw new PaymentCornerExceptions('page_nb can only be numeric', 412);
        }
        $this->result_per_page = $result_per_page;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * @param mixed $sort_order
     * @throws PaymentCornerExceptions
     */
    public function setSortOrder($sort_order)
    {
        if (!in_array($sort_order, array('amount_to_sell', 'amount_to_buy', 'fx_tx_creation_date', 'fx_tx_update_date', 'currency_to_buy', 'currency_to_sell', 'currency_pair', 'date_of_settlement', 'fx_tx_date'))) {
            throw new PaymentCornerExceptions('sort_order should be in range: fx_tx_creation_date, fx_tx_update_date, currency_to_buy, currency_to_sell, currency_pair, amount_to_sell, amount_to_buy, date_of_settlement, fx_tx_date', 412);
        }
        $this->sort_order = $sort_order;
    }

    /**
     * @return mixed
     */
    public function getSortAscToDesc()
    {
        return $this->sort_asc_to_desc;
    }

    /**
     * @param mixed $sort_asc_to_desc
     * @throws PaymentCornerExceptions
     */
    public function setSortAscToDesc($sort_asc_to_desc)
    {
        if (!in_array($sort_asc_to_desc, array('asc', 'desc'))) {
            throw new PaymentCornerExceptions('sort_asc_to_desc can either be asc or desc', 412);

        }
        $this->sort_asc_to_desc = $sort_asc_to_desc;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getNewDateFxTx()
    {
        return $this->new_date_fx_tx;
    }

    /**
     * @param mixed $new_date_fx_tx
     * @throws PaymentCornerExceptions
     */
    public function setNewDateFxTx($new_date_fx_tx)
    {
        if (!$this->validateDate($new_date_fx_tx)) {
            throw new PaymentCornerExceptions('new_date_fx_tx should be in ISO 8601 format', 412);
        }
        $this->new_date_fx_tx = $new_date_fx_tx;
    }


}