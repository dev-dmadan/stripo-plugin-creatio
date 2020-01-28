<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class TestEmail extends Controller {

    private $mail;

    public function __construct() {
        require_once CONTROLLER. 'GetAuthCreatioController.php';
        $authCreatio = new GetAuthCreatio();
        $authCreatio->verifyJWTToken();
    }

    public function index() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("Accept: application/json");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $message = '';
        $check = true;
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data)) {
            if(!isset($data->to) || empty($data->to)) {
                $message .= 'To (Email) is required.';
                $check = false;
            }

            if(!isset($data->html)) {
                $message .= 'HTML is required.';
                $check = false;
            }
        }
        else {
            $this->requestError(400, 'Please check your parameter');
        }

        if(!$check) {
            $this->requestError(400, $message);
        }

        $sendEmail = $this->sendEmail($data->to, (isset($data->templateName) ? $data->templateName : ''), $data->html, null, true);
        echo json_encode($sendEmail);
    }
}