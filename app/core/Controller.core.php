<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

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
    final protected function model($name) {
        $class = ucfirst(strtolower($name));
        require_once ROOT.DS. 'app' .DS. 'model' .DS.$class. 'php';
        $this->$name = new $class();
    }

    /**
     * 
     */
    final protected function view($name) {
        $temp = explode('/', $name);
			
        $view = '';
        for($i=0; $i<count($temp); $i++){
            if((count($temp)-$i!=1)) {
                $view .= $temp[$i].DS;
            }
            else {
                $view .= $temp[$i];
            }
        }
        
        require_once ROOT.DS. 'app' .DS. 'view' .DS.$view. '.php';
        die();
    }

    /**
     * 
     */
    final public function redirect($url = BASE_URL){
        header("Location: {$url}");
        die();
    }
}