<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class Home extends Controller {

    /**
     * 
     */
    public function index() {
        $this->view('hello');
    }

}