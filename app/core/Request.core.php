<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class Request {

    /**
     * 
     */
    public function call($request = "") {
        $uri = explode('/', $request);
        $class = (isset($uri[0]) && (!empty($uri[0]))) ? ucfirst(strtolower($uri[0])) : ucfirst(DEFAULT_CONTROLLER);
        $method = isset($uri[1]) ? strtolower($uri[1]) : 'index';

        $controller = ROOT.DS. 'app' .DS. 'controller'. DS.ucfirst(strtolower($class)). 'Controller.php';

        $classExists = $methodExists = false;
        if(file_exists($controller)) {
            $classExists = true;

            require_once $controller;
            $object = new $class();

            if(method_exists($object, $method)) {
                $methodExists = true;

                $object->$method();
            }
        }

        // var_dump(array(
        //     'uri' => $uri,
        //     'class' => $class,
        //     'method' => $method,
        //     'file' => $controller,
        //     'classExists' => $classExists,
        //     'methodExists' => $methodExists
        // ));
    }
}