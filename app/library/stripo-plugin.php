<?php

use \Curl\Curl;

class Stripo {

    public $token;
    public $html;
    public $css;
    public $minimize;
    public $htmlFull;

    private $baseURL = 'https://plugins.stripo.email/api/v1/';
    private $uri = array(
        'auth' => 'auth',
        'compress' => 'cleaner/v1/compress'
    );
    private $pluginId;
    private $secretKey;
    private $success = false;
    private $error = array(
        'code' => '',
        'message' => ''
    );
    private $curl;

    public function __construct() {
        $this->curl = new Curl();
        $this->uri['auth'] = $this->baseURL . $this->uri['auth'];
        $this->uri['compress'] = $this->baseURL . $this->uri['compress'];
    }

    /**
     * 
     */
    public function getToken($pluginId, $secretKey) {
        $this->token = '';
        $this->pluginId = $pluginId;
        $this->secretKey = $secretKey;

        $auth = $this->getAuth();
        if($auth['success']) {
            $this->token = $auth['response']->token;
        }

        return $this->token;
    }

    /**
     * 
     */
    public function getHtmlFull($token, $html, $css, $minimize = true) {
        $this->htmlFull = '';
        $this->token = $token;
        $this->html = $html;
        $this->css = $css;
        $this->minimize = $minimize;

        $compress = $this->getCompress();
        if($compress['success']) {
            $this->htmlFull = $compress['response']->html;
        }

        return $this->htmlFull;
    }

    /**
     * 
     */
    private function getAuth() {
        $result = array();

        $this->curl->setHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ));
        $this->curl->post($this->uri['auth'], array(
            'pluginId' => $this->pluginId,
            'secretKey' => $this->secretKey
        ));

        if ($this->curl->error) {
            $this->error['code'] = $this->curl->errorCode;
            $this->error['message'] = $this->curl->errorMessage;
        }

        $result['response'] = $this->curl->response;
        $result['status_code'] = $this->curl->getHttpStatusCode();
        $result['error'] = $this->error;

        if((empty($this->error['code'] && empty($this->error['message'])) && !empty($this->curl->response)) && isset($this->curl->response->token)) {
            $this->success = true;
        }
        $result['success'] = $this->success;

        return $result;
    }

    /**
     * 
     */
    private function getCompress() {
        $result = array(
            'response' => null,
            'status_code' => 0,
            'error' => null,
            'success' => false
        );

        $this->curl->setHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'ES-PLUGIN-AUTH' => 'Bearer '.$this->token
        ));
        $this->curl->post($this->uri['compress'], array(
            'html' => $this->html,
            'css' => $this->css,
            'minimize' => $this->minimize
        ));

        if ($this->curl->error) {
            $this->error['code'] = $this->curl->errorCode;
            $this->error['message'] = $this->curl->errorMessage;
        }

        $result['response'] = $this->curl->response;
        $result['status_code'] = $this->curl->getHttpStatusCode();
        $result['error'] = $this->error;

        if((empty($this->error['code'] && empty($this->error['message'])) && !empty($this->curl->response)) && isset($this->curl->response->html)) {
            $this->success = true;
        }
        $result['success'] = $this->success;

        return $result;
    }
}