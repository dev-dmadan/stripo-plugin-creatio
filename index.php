<?php

define('BASE_PATH', true);
define('ACCESS_DENIED', json_encode(array('success' => false, 'message' => 'Access Denied'), JSON_PRETTY_PRINT));
define('ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

/**
 * Const ENVIRONMENT
 * By Default: DEV, DEV-LIVE, PROD
 * DEV      => Local only
 * DEV-LIVE => Development in cloud/host
 * PROD     => Golive / production
 */
define('ENVIRONMET', "DEV");

date_default_timezone_set('Asia/Jakarta');
session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/configuration/config.php';
require_once __DIR__ . '/app/core/Controller.core.php';
require_once __DIR__ . '/app/core/Database.core.php';
require_once __DIR__ . '/app/core/Auth.core.php';

/** Put Library Here */

require_once __DIR__ . '/app/library/stripo-plugin.php';
require_once __DIR__ . '/app/library/request-creatio.php';

/** End Put Library Here */

require_once __DIR__ . '/app/core/Request.core.php';
require_once __DIR__ . '/app/configuration/route.php';