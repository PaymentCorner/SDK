<?php

class ApiClient
{
    public $baseURL = 'http://sandboxapi.paymentcorner.com';
    public $client_id;

    /**
     * @throws PaymentCornerExceptions
     **/
    public function doPost($URLEndpoint, $params, $token = null)
    {
        return $this->doRequest($this->baseURL . $URLEndpoint, $params, $token);
    }

    /**
     * @throws PaymentCornerExceptions
     **/

    private function doRequest($url, $urlParams, $token = null)
    {
        $headers = array(
            "cache-control: no-cache",
        );
        if (!empty($token)) {
            array_push($headers, 'auth_token:' . $token);
            $urlParams['client_id'] = $this->client_id;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $urlParams);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result = json_decode($result, true);
        if ($result == false) {
            throw new PaymentCornerExceptions("Internal server error", 500);

        }
        if ($result['code'] != 200) {
            $this->formatError($result);
        }
        return $result['result'];


    }

    /**
     * @throws PaymentCornerExceptions
     **/
    private function formatError($error)
    {
        $finalError = '';
        if (is_array($error['error'])) {
            foreach ($error['error'] as $key => $value) {
                $finalError .= empty($finalError) ? $value : ',' . $value;

            }
            $message = $finalError;
        } else {
            $message = $error['error'];
        }

        throw new PaymentCornerExceptions($message, $error['code']);

    }


}