<?php

use \Curl\Curl;

class RequestCreatioRest {

    private $curl;
    private $url;

    public function __construct($url) {
        $this->curl = new Curl();
        $this->url = $url;
    }

    /**
     * 
     */
    public function request($BPMCSRF, $method, $endpoint, $data) {
        $result = (Object)array(
            'success' => false,
            'message' => '',
            'response' => null
        );
        $url = (substr($this->url, -1) == '/' ? $this->url : $this->url.'/'). '0/rest/'.$endpoint['service']. '/' .$endpoint['method'];

        echo $url. '<br>';
        echo $BPMCSRF. '<br>';
        echo 'Data: <br>';

        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        $this->curl->setHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'BPMCSRF' => $BPMCSRF,
            'ForceUseSession' => 'true'
        ));
        // $this->curl->setCookieJar('cookies.txt');
        $this->curl->setCookieFile('cookies.txt');

        switch (strtolower($method)) {
            case 'post':
                $this->curl->post($url, $data);
                break;

            case 'get':
                $this->curl->get($url, $data);
                break;

            case 'put':
                $this->curl->put($url, $data);
                break;

            case 'delete':
                $this->curl->delete($url, $data);
                break;
            
            default:
                $this->curl->post($url, $data);
                break;
        }

        echo '<pre>';
        echo 'Error: ';
        var_dump($this->curl->error);
        
        echo 'Error Code: ';
        var_dump($this->curl->errorCode);
        
        echo 'Error Message: ';
        var_dump($this->curl->errorMessage);
        
        echo 'Request Headers: ';
        var_dump($this->curl->getRequestHeaders());
        
        echo 'Response Headers: ';
        var_dump($this->curl->getResponseHeaders());

        echo 'Response Cookies: ';
        var_dump($this->curl->getResponseCookies());
        
        echo '</pre>';

        $result->success = ($this->curl->error) ? false : true;
        $result->message = ($this->curl->error) ? 'Error Code: ' .$this->curl->errorCode. ".\nMessage: " .$this->curl->errorMessage : '';
        $result->response = $this->curl->response;

        return $result;
    }

}