<?php

require_once 'request-rest.php';
require_once 'request-odata.php';

use \Curl\Curl;

class RequestCreatio {

    private $rest;
    private $oData;
    private $url;
    private $username;
    private $password;
    private $header;
    private $cookies;
    private $param;
    private $body;
    private $success = false;
    private $error = array(
        'code' => '',
        'message' => ''
    );
    private $curl;

    public function __construct($url, $username, $password) {
        $this->curl = new Curl();

        $this->rest = new RequestCreatioRest($url);
        $this->oData = new RequestCreatioOData($url);

        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * 
     */
    public function test() {
        return $this->getAuth();
    }

    /**
     * 
     */
    public function request($type, $method, $endpoint, $data) {
        $result = null;

        switch (strtolower($type)) {
            case 'odata':
                $result = $this->requestOData();
                break;
            case 'rest':
            default:
                $result = $this->requestRest();
                break;
        }

        return $result;
    }

    /**
     * 
     */
    private function getAuth() {
        $result = array();

        $url = (substr($this->url, -1) == '/' ? $this->url : $this->url.'/'). 'ServiceModel/AuthService.svc/Login';
        $credential = array(
            'UserName' => $this->username,
            'UserPassword' => $this->password
        );

        $this->curl->setHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ));
        $this->curl->setCookieJar('cookies.txt');
        $this->curl->setCookieFile('cookies.txt');
        $this->curl->post($url, $credential);
        
        if ($this->curl->error) {
            $this->error['code'] = $this->curl->errorCode;
            $this->error['message'] = $this->curl->errorMessage;
        }

        $result['response'] = $this->curl->response;
        $result['cookies'] = $this->curl->responseCookies;
        $result['BPMCSRF'] = isset($this->curl->responseCookies['BPMCSRF']) ? $this->curl->responseCookies['BPMCSRF'] : null;
        $result['status_code'] = $this->curl->getHttpStatusCode();
        $result['error'] = $this->error;

        $checkError = ((empty($this->error['code']) && empty($this->error['message'])) && !empty($this->curl->response));
        $checkResponseCode = (isset($this->curl->response->Code) && $this->curl->response->Code == 0);
        $checkResponseException = (isset($this->curl->response->Exception) && $this->curl->response->Exception == null);
        if($checkError && ($checkResponseCode || $checkResponseException)) {
            $this->success = true;
        }
        $result['success'] = $this->success;

        return $result;
    }

    /**
     * 
     */
    private function requestRest() {

    }

    /**
     * 
     */
    private function requestOData($json = true) {

    }
}