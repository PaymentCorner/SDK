<?php
/**
 * Created by PhpStorm.
 * User: rahul
 * Date: 27/12/18
 * Time: 11:54 AM
 */

class PaymentCorner
{
    /**
     * The program token
     *
     * @var string
     */
    private $programToken;
    private $client;

    /**
     * @throws PaymentCornerExceptions
     **/
    public function __construct($email, $password, $client_id, $devMode = false)
    {
        if (empty($email) || empty($password) || empty($client_id)) {
            throw new PaymentCornerExceptions('Please specify email, password and client_id', 412);
        }
        $this->client = new ApiClient();
        if ($devMode) {
            $this->client->baseURL = 'http://productionapi.paymentcorner.com';
        }
        $this->client->client_id = $client_id;

        try {
            $this->login(array('email' => $email, 'password' => $password, 'session_time' => 5));
        } catch (Exception $exception) {
            throw new PaymentCornerExceptions($exception->getMessage(), $exception->getCode(), $exception);
        }


    }

    private function login($credentials)
    {
        $result = $this->client->doPost('/login', $credentials);
        $this->programToken = $result['auth_token'];

    }

    public function fxTransaction(Transactions $transactions)
    {
        $_required = array(
            'currency_to_buy',
            'currency_to_sell',
            'side_of_fx_tx',
            'amount',
            'fx_tx_gtc'
        );
        EmptyCheckHandler::onSetAndEmptyCheckHandler((array)$transactions, $_required, $_required);
        $result = $this->client->doPost('/fx-transaction', (array)$transactions, $this->programToken);
        throw new PaymentCornerExceptions(json_encode($result, true), 200);

    }

    public function retrieveFxTransaction(Transactions $transactions)
    {

        $_required = array();
        EmptyCheckHandler::onSetAndEmptyCheckHandler((array)$transactions, $_required, $_required);
        $result = $this->client->doPost('/retrieve-fx-transaction', (array)$transactions, $this->programToken);
        throw new PaymentCornerExceptions(json_encode($result, true), 200);


    }

    public function retrieveFxTransactionRecord(Transactions $transactions)
    {
        $_required = array(
            'path'
        );
        EmptyCheckHandler::onSetAndEmptyCheckHandler((array)$transactions, $_required, $_required);
        $result = $this->client->doPost('/retrieve-fx-transaction-record', (array)$transactions, $this->programToken);
        throw new PaymentCornerExceptions(json_encode($result, true), 200);

    }

    public function changeFxConversionValueDate(Transactions $transactions)
    {
        $_required = array(
            'new_date_fx_tx'
        );
        EmptyCheckHandler::onSetAndEmptyCheckHandler((array)$transactions, $_required, $_required);
        $result = $this->client->doPost('/change-fx-conversion-value-date', (array)$transactions, $this->programToken);
        throw new PaymentCornerExceptions(json_encode($result, true), 200);

    }

    public function changeFxConversionDeliveryDateQuotation(Transactions $transactions)
    {
        $_required = array(
            'new_date_fx_tx'
        );
        EmptyCheckHandler::onSetAndEmptyCheckHandler((array)$transactions, $_required, $_required);
        $result = $this->client->doPost('/change-fx-conversion-delivery-date-quotation', (array)$transactions, $this->programToken);
        throw new PaymentCornerExceptions(json_encode($result, true), 200);

    }

    public function fxMarketRatewMarkUp(Rates $rates)
    {
        $_required = array(
            'currency_to_buy',
            'currency_to_sell',
            'side_of_fx_tx',
            'amount'
        );

        EmptyCheckHandler::onSetAndEmptyCheckHandler((array)$rates, $_required, $_required);
        $result = $this->client->doPost('/fx-market-rate-w/mark-up', (array)$rates, $this->programToken);
        throw new PaymentCornerExceptions(json_encode($result, true), 200);

    }

    public function fxMarketRate(Rates $rates)
    {

        $_required = array(
            'currency_pair'
        );
        EmptyCheckHandler::onSetAndEmptyCheckHandler((array)$rates, $_required, $_required);
        $result = $this->client->doPost('/fx-market-rate', (array)$rates, $this->programToken);
        throw new PaymentCornerExceptions(json_encode($result, true), 200);

    }


}

