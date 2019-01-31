<?php


class PaymentCornerExceptions extends Exception
{

    public function __construct($message, $code = null, Exception $previous = null)
    {
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }


}