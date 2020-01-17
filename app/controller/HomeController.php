<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class Home extends Controller {

    private $stripo;
    private $creatio;

    public function __construct() {
        require_once CONTROLLER. 'GetAuthCreatioController.php';
        $authCreatio = new GetAuthCreatio();
        $authCreatio->verifyJWTToken();

        $this->stripo = new Stripo();
        $this->model('StripoModel');

        $this->creatio = new RequestCreatio(BASE_URL_CREATIO, USERNAME_CREATIO, PASSWORD_CREATIO);

        if(!isset($_SESSION['TOKEN_STRIPO']) || empty($_SESSION['TOKEN_STRIPO'])) {
            $getPluginStripo = $this->getPluginStripo();
            $tokenStripo = $this->stripo->getToken($getPluginStripo['pluginId'], $getPluginStripo['secretKey']);
            if(!empty($tokenStripo)) {
                $_SESSION['TOKEN_STRIPO'] = $tokenStripo;
            }
        }
    }

    /**
     * 
     */
    public function index() {
        $emailId = isset($_GET['emailId']) && !empty($_GET['emailId']) ? $_GET['emailId'] : false;
        $templateId = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : false;
        $templateName = isset($_GET['name']) && !empty($_GET['name']) ? $_GET['name'] : false;
        $macro = isset($_GET['macro']) && !empty($_GET['macro']) ? $_GET['macro'] : false;
        $action = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : false;

        if($templateId && ($action && strtolower($action) == 'add')) {
            $this->editorAdd($templateId, $emailId);
        }
        else if($templateId && $emailId && ($action && strtolower($action) == 'edit')) {
            $this->editorEdit($templateId);
        }
        else {
            header("Content-Type: application/json");
            header("Accept: application/json");
            $this->requestError(400, 'Please check parameter request');
        }

        $data = array(
            'emailId' => $emailId ?? '',
            'templateId' => $templateId ?? '',
            'templateName' => $templateName ?? '',
            'macro' => $macro ?? '',
            'action' => $action ?? ''
        );
        $this->view('emaileditor/editor', $data);
    }

    /**
     * 
     */
    public function add() {

    }

    /**
     * 
     */
    public function edit() {
        
    }

    /**
     * 
     */
    private function editorAdd($templateId, $emailId) {
        // generate emailId dan update emailId ke bpm

        // save local
        echo 'Editor Add';
    }

    /**
     * 
     */
    private function editorEdit($templateId) {
        // get html stripo, dan css stripo based on id

        // update local
        echo 'Editor Edit';
    }

    /**
     * 
     */
    public function getTokenStripo() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("Accept: application/json");
        header("Access-Control-Allow-Methods: POST");

        $tokenStripo = '';
        if(isset($_SESSION['TOKEN_STRIPO']) && !empty($_SESSION['TOKEN_STRIPO'])) {
            $tokenStripo = $_SESSION['TOKEN_STRIPO'];
        }
        else {
            $getPluginStripo = $this->getPluginStripo();
            $tokenStripo = $this->stripo->getToken($getPluginStripo['pluginId'], $getPluginStripo['secretKey']);
            if(empty($tokenStripo)) {
                $this->requestError(400, 'Get Token Stripo is failed. Please try again');
            }

            $_SESSION['TOKEN_STRIPO'] = $tokenStripo;
        }

        http_response_code(200);
        echo json_encode(array('token' => $tokenStripo), JSON_PRETTY_PRINT);
    }
    
    /**
     * 
     */
    public function getHtmlFull() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("Accept: application/json");
        header("Access-Control-Allow-Methods: POST");

        $check = true;
        $message = '';

        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data)) {
            if(!isset($data->html) || empty($data->html)) {
                $message .= 'HTML is required.';
                $check = false;
            }
 
            if(!isset($data->css) || empty($data->css)) {
                $message .= ' CSS is required.';
                $check = false;
            }
        }

        if(!$check) {
            $this->requestError(400, $message);
        }

        $check = true;
        $i = 0;
        
        $token = (isset($_SESSION['TOKEN_STRIPO']) && !empty($_SESSION['TOKEN_STRIPO'])) ? $_SESSION['TOKEN_STRIPO'] : $this->stripo->getToken($getPluginStripo['pluginId'], $getPluginStripo['secretKey']);
        while($i < 3) {
            $htmlFull = $this->stripo->getHtmlFull($token, $html, $css, $minimize);
            if(empty($htmlFull)) {
                $check = false;
            }
            else {
                break;
            }

            if(!$check) {
                $token = $this->stripo->getToken($getPluginStripo['pluginId'], $getPluginStripo['secretKey']);
                $_SESSION['TOKEN_STRIPO'] = $token;
            }

            $i++;
        }
        
        if(!$check) {
            $this->requestError(400, 'Get Full HTML is failed. Please try again');
        }

        http_response_code(200);
        echo json_encode(array('html' => $htmlFull), JSON_PRETTY_PRINT);
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