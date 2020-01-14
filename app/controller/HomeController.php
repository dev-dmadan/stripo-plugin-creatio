<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class Home extends Controller {

    private $stripo;

    public function __construct() {
        require_once CONTROLLER. 'GetAuthCreatioController.php';
        $authCreatio = new GetAuthCreatio();
        $authCreatio->verifyJWTToken();

        $this->stripo = new Stripo();
        $this->model('StripoModel');
    }

    /**
     * 
     */
    public function index() {
        $data = array();
        $this->view('emaileditor/editor', $data);
    }

    /**
     * 
     */
    public function getTokenStripo() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("Accept: application/json");
        header("Access-Control-Allow-Methods: POST");

        $getPluginStripo = $this->getPluginStripo();
        $tokenStripo = $this->stripo->getToken($getPluginStripo['pluginId'], $getPluginStripo['secretKey']);
        if(empty($tokenStripo)) {
            $this->requestError(400, 'Get Token Stripo is failed. Please try again');
        }

        http_response_code(200);
        echo json_encode(array('token' => $tokenStripo), JSON_PRETTY_PRINT);
    }
    
    /**
     * 
     */
    private function getPluginStripo() {
        $result = array(
            'pluginId' => 'c570a38a2dec4fef80c9d6c5d8aea09b',
            'secretKey' => 'd83328ff24e54477a019bb3c6f6b9df8'
        );

        return $result;
    }

    /**
     * 
     */
    private function requestError($errorCode, $message) {
        http_response_code($errorCode);
        echo json_encode(array(
            'success' => false,
            'message' => $message
        ), JSON_PRETTY_PRINT);

        die();
    }
}