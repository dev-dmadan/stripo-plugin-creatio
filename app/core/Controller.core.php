<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Controller {

    /**
     * 
     */
    final protected function auth($name = 'auth') {
        $this->$name = new Auth();
    }

    /**
     * 
     */
    final protected function model($name, $alias = '') {
        require_once MODEL.$name. '.php';
        
        if(!empty($alias)) {
            $this->$alias = new $name();
        }
        else {
            $this->$name = new $name();
        }
    }

    /**
     * Method sendEmail
     * @param {string / array} to
     *              to {string}
     *              to {array}
     *              [
     *                  'to' => '', || 'to' => ['', '', ...] || 'to' => ['name' => 'email', ...]
     *                  'cc' => '', || 'cc' => ['', '', ...] || 'cc' => ['name' => 'email', ...]
     *              ]
     * @param {string} subject
     * @param {string} message
     * @param {array} attachment
     * @param {boolean} isHTML
     * @return {object} result
     *              result.success {boolean}
     *              result.message {string}
     */
    final public function sendEmail($to, $subject, $message, $attchment = null, $isHTML = false) {
        $result = (Object)array(
            'success' => false,
            'message' => ''
        );

        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF; 
            $mail->isSMTP();
            $mail->Host       = HOST_EMAIL;
            $mail->SMTPAuth   = true;
            $mail->Username   = USERNAME_EMAIL;
            $mail->Password   = PASSWORD_EMAIL;
            $mail->SMTPSecure = strtolower(SMTP_SECURE_EMAIL) == 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = PORT_EMAIL;

            $mail->setFrom(USERNAME_EMAIL, NAME_EMAIL);
            
            // Set To
            if(is_array($to) && isset($to['to'])) {
                if(is_array($to['to']) && count($to['to']) > 0) {
                    foreach($to['to'] as $nameTo => $emailTo) {
                        if(is_string($nameTo)) {
                            $mail->addAddress($emailTo, $nameTo);
                        }
                        else {
                            $mail->addAddress($emailTo);
                        }
                    }
                }
                else {
                    $mail->addAddress($to['to']);
                }
            }
            else {
                $mail->addAddress($to);
            }

            // Set CC
            if(is_array($to) && isset($to['cc'])) {
                if(is_array($to['cc']) && count($to['cc']) > 0) {
                    foreach($to['cc'] as $nameCC => $emailCC) {
                        if(is_string($nameCC)) {
                            $mail->addCC($nameCC, $emailCC);
                        }
                        else {
                            $mail->addCC($emailCC);
                        }
                    }
                }
                else {
                    $mail->addCC($to['cc']);
                }
            }

            $mail->isHTML($isHTML);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            $result->success = true;
        } 
        catch (Exception $e) {
            $result->message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $result;
    }

    /**
     * 
     */
    final public function requestError($errorCode, $message, $json = true) {
        http_response_code($errorCode);
        if($json) {
            header("Content-Type: application/json");
            header("Accept: application/json");
            echo json_encode(array(
                'success' => false,
                'message' => $message
            ), JSON_PRETTY_PRINT);

            die();
        }
        
        $this->view('error/error', array(
            'error' => $errorCode,
            'message' => $message
        ));
    }

    /**
     * 
     */
    final public function view($name, $data = null, $return = false) {
        $temp = explode('/', $name);
			
        $viewPath = '';
        for($i=0; $i<count($temp); $i++){
            if((count($temp)-$i!=1)) {
                $viewPath .= $temp[$i].DS;
            }
            else {
                $viewPath .= $temp[$i];
            }
        }
        
        ob_start();
        if(!empty($data)) {
            foreach($data as $key => $value) {
                ${$key} = $value;
            }
        }
        require_once ROOT.DS. 'app' .DS. 'view' .DS.$viewPath. '.php';
        $view = ob_get_contents();
        ob_end_clean();

        if($return) {
            return $view;
        }

        echo $view;
        die();
    }

    /**
     * 
     */
    final public function redirect($url = SITE_URL){
        header("Location: {$url}");
        die();
    }
}