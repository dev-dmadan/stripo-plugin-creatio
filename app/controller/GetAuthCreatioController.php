<?php

use \Firebase\JWT\JWT;

class GetAuthCreatio {

    private $token;
    private $success;
    private $message;
    private $data;

    public function __construct() {
        // $this->model('AuthCreatio');
    }

    /**
     * 
     */
    public function index() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("Accept: application/json");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        
        $result = array(
            'success' => false,
            'message' => '',
            'token' => ''
        );

        $this->data = json_decode(file_get_contents("php://input"));
        $validate = $this->validateData($this->data);
        if(!$validate['success']) {
            $result['success'] = false;
            $result['message'] = $validate['message'];

            http_response_code(400);
            echo json_encode($result, JSON_PRETTY_PRINT);
            die();
        }

        $checkToken = $this->checkToken($this->data->token);
        if(!$checkToken['success']) {
            $result['success'] = false;
            $result['message'] = $checkToken['message'];

            http_response_code(400);
            echo json_encode($result);
            die();
        }

        $result['success'] = true;
        $result['message'] = $validate['message'];
        $result['token'] = $this->generateJWTToken($this->data->username, $this->data->source);
        
        http_response_code(200);
        echo json_encode($result, JSON_PRETTY_PRINT);
        die();
    }

    /**
     * 
     */
    private function validateData() {
        $result = array(
            'success' => false,
            'message' => ''
        );
        $source = array(
            'https://citilink.bpmonline.com', 'https://citilinksales.bpmonline.com', 'https://citilinkmarketing.bpmonline.com',
            'http://citilink.bpmonline.com', 'http://citilinksales.bpmonline.com', 'http://citilinkmarketing.bpmonline.com',
            'https://citilink.creatio.com', 'https://citilinksales.creatio.com', 'https://citilinkmarketing.creatio.com',
            'http://citilink.creatio.com', 'http://citilinksales.creatio.com', 'https//citilinkmarketing.creatio.com',
        );
        $check = true;

        if(!empty($this->data)) {
            if(!isset($this->data->token) || empty($this->data->token)) {
                $result['message'] .= 'Token is required.';
                $check = false;
            }
 
            if(!isset($this->data->username) || empty($this->data->username)) {
                $result['message'] .= ' Username is required.';
                $check = false;
            }

            if(!isset($this->data->source) || empty($this->data->source)) {
                $result['message'] .= ' Source is required.';
                $check = false;
            }
            else if(!in_array($this->data->source, $source)) {
                $result['message'] .= ' Source is incorrect.';
                $check = false;
            }
        }

        $result['message'] = trim($result['message']);
        $result['success'] = $check;

        return $result;
    }

    /**
     * 
     */
    private function checkToken($token) {
        // raw original key                 : tokenAkses_keStripoPlugin_creatioPunya
        // md5 original key                 : 2a4a215c0f46c9fd8895e0840b0498ac
        // md5 hash bycrypt original key    : $2y$10$ojCgSMtNAq4XOGmDm9b62utdUTNF2lETOePa/azD8h2d/XpUJEvLO
        $result = array(
            'success' => false,
            'message' => ''
        );

        $result['success'] = password_verify($token, '$2y$10$ojCgSMtNAq4XOGmDm9b62utdUTNF2lETOePa/azD8h2d/XpUJEvLO');
        $result['message'] = $result['success'] ? '' : 'Access Denied: Invalid Token';

        return $result;
    }

    /**
     * 
     */
    private function generateJWTToken($username, $source) {        
        $payload = array(
            "iss" => "https://citilink.bpmonline.asia/email-editor",
            "aud" => $source,
            "iat" => time(),
            "nbf" => time() + 10,
            "exp" => time() + 3600,
            "data" => array(
                "username" => $username,
                "source" => $source
            )
        );

        $jwt = JWT::encode($payload, TOKEN_AUTH_CREATIO);

        return $jwt;
    }

    /**
     * 
     */
    public function verifyJWTToken() {
        $authHeader = empty($_SERVER['HTTP_AUTHORIZATION']) ? (isset($_GET['auth']) ? $_GET['auth'] : false) : $_SERVER['HTTP_AUTHORIZATION'];
        if(!$authHeader) {
            header("Content-Type: application/json");
            header("Accept: application/json");
            http_response_code(401);
            echo json_encode(array(
                'success' => false,
                'message' => 'Access Denied'
            ), JSON_PRETTY_PRINT);
            die();
        }
        
        if(isset($_GET['auth'])) {
            $JWT = $authHeader;
        }
        else {
            $tempJWT = explode("Bearer ", $authHeader);
            $JWT = isset($tempJWT[1]) ? $tempJWT[1] : false;
        }

        if(!$JWT) {
            return false;
        }

        try {
            $decoded = JWT::decode($JWT, TOKEN_AUTH_CREATIO, array('HS256'));
        }
        catch(Exception $e) {
            header("Content-Type: application/json");
            header("Accept: application/json");
            http_response_code(401);
            echo json_encode(array(
                'success' => false,
                'message' => 'Access Denied',
                'error' => $e->getMessage()
            ), JSON_PRETTY_PRINT);
            die();
        }

        return true;
    }
}