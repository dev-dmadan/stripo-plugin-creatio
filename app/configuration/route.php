<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

$controller = new Request();
$route = new \Klein\Klein();

/**
 * Put your route here
 * $route->responsd($method, $url, $closure)
 */

/** Your custom route */

    $route->respond('GET', '/', function() use ($controller) {
        $controller->call();
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