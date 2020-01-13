<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

/** USE THIS CODE IF YOUR PROJECT IN SUBDIRECTORY  */
    $base  = dirname($_SERVER['PHP_SELF']);
    if(ltrim($base, '/')) { 
        $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
    }
/** USE THIS CODE IF YOUR PROJECT IN SUBDIRECTORY */

$controller = new Request();
$route = new \Klein\Klein();

/**
 * Put your route here
 * $route->responsd($method, $url, $closure)
 */

/** Your custom route */

    // editor
    $route->respond('GET', '/', function() use ($controller) {
        $controller->call();
    });
    
    // get token stripo
    $route->respond('POST', '/get-token-stripo', function() use ($controller) {
        $controller->call('Home/getTokenStripo', true);
    });

    // get auth to creatio
    $route->respond('POST', '/get-auth', function() use ($controller) {
        $controller->call('GetAuthCreatio/index', true);
    });

    /** Login */
    $route->respond('GET', '/login', function() use ($controller) {
        $controller->call('login');
    });
    $route->respond('POST', '/login', function() use ($controller) {
        $controller->call('login/doLogin');
    });
    /** End Login */

    /** Error Request */
    $route->onHttpError(function($code, $router) {
        switch ($code) {
            case 404:
                $router->response()->body(
                    'Y U so lost?!'
                );
                break;
            case 405:
                $router->response()->body(
                    'You can\'t do that!'
                );
                break;
            default:
                $router->response()->body(
                    'Oh no, a bad error happened that caused a '. $code
                );
        }
    });
    /** End Error Request */

/** End Your custom route */

$route->dispatch();