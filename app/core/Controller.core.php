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
    final protected function model($name, $alias = '') {
        require_once MODEL.$name. '.php';
        
        if(empty($alias)) {
            $this->$alias = new $name();
        }
        else {
            $this->$name = new $name();
        }
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