<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

/**
 * Configuration URL
 */
define('BASE_URL', 'http://localhost/hello-framework-lite/');
define('SITE_URL', BASE_URL. "index.php/");
define('CONTROLLER', '');
define('MODEL', '');
define('ASSETS', BASE_URL);

/**
 * Default Controller
 */
define('DEFAULT_CONTROLLER', 'home');

/**
 * Configuration Database
 */
define('DB_HOST', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');