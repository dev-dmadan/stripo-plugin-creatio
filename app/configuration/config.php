<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

$configuration = array();
switch (ENVIRONMET) {
    case 'PROD':

        /**
         * Configuration URL
         */
        $configuration['BASE_URL'] = '';
        $configuration['SITE_URL'] = '';
        $configuration['CONTROLLER'] = '';
        $configuration['MODEL'] = '';
        $configuration['ASSETS'] = '';
        

        /**
         * Default Controller
         */
        
        $configuration['DEFAULT_CONTROLLER'] = '';

        
        /**
         * Creatio Integration Setup
         */
        $configuration['KEY_AUTH'] = '';
        $configuration['BASE_URL_CREATIO'] = '';
        $configuration['USERNAME_CREATIO'] = '';
        $configuration['PASSWORD_CREATIO'] = '';
        

        /**
         * Configuration Database
         */
        $configuration['USE_SQL_BUILDER'] = true;
        $configuration['DB_HOST'] = '';
        $configuration['DB_USERNAME'] = '';
        $configuration['DB_PASSWORD'] = '';
        $configuration['DB_NAME'] = '';

        break;
    case 'DEV-LIVE':

        /**
         * Configuration URL
         */
        $configuration['BASE_URL'] = '';
        $configuration['SITE_URL'] = '';
        $configuration['CONTROLLER'] = '';
        $configuration['MODEL'] = '';
        $configuration['ASSETS'] = '';
        

        /**
         * Default Controller
         */
        
        $configuration['DEFAULT_CONTROLLER'] = '';

        
        /**
         * Creatio Integration Setup
         */
        $configuration['KEY_AUTH'] = '';
        $configuration['BASE_URL_CREATIO'] = '';
        $configuration['USERNAME_CREATIO'] = '';
        $configuration['PASSWORD_CREATIO'] = '';
        

        /**
         * Configuration Database
         */
        $configuration['USE_SQL_BUILDER'] = true;
        $configuration['DB_HOST'] = '';
        $configuration['DB_USERNAME'] = '';
        $configuration['DB_PASSWORD'] = '';
        $configuration['DB_NAME'] = '';

        break;
    case 'DEV':
    default:
        
        /**
         * Configuration URL
         */
        $configuration['BASE_URL'] = 'http://localhost/iSystemAsia/stripo-plugin-creatio/';
        $configuration['SITE_URL'] = 'http://localhost:8000/';
        $configuration['CONTROLLER'] = ROOT.DS. 'app' .DS. 'controller' .DS;
        $configuration['MODEL'] = ROOT.DS. 'app' .DS. 'model' .DS;
        $configuration['ASSETS'] = $configuration['BASE_URL']. 'assets/';
        
        /**
         * Default Controller
         */
        
        $configuration['DEFAULT_CONTROLLER'] = 'home';
        
        /**
         * Creatio Integration Setup
         */
        $configuration['KEY_AUTH'] = '2a4a215c0f46c9fd8895e0840b0498ac';
        $configuration['BASE_URL_CREATIO'] = 'http://localhost:8083';
        $configuration['USERNAME_CREATIO'] = 'Supervisor';
        $configuration['PASSWORD_CREATIO'] = 'Supervisor';

        /**
         * Configuration Database
         */
        $configuration['USE_SQL_BUILDER'] = true;
        $configuration['DB_HOST'] = 'localhost';
        $configuration['DB_USERNAME'] = 'root';
        $configuration['DB_PASSWORD'] = '';
        $configuration['DB_NAME'] = 'dev-stripo';

        break;
}

/** DONT CHANGE IT DIRECTLY */
    define('BASE_URL', $configuration['BASE_URL']);
    define('SITE_URL', $configuration['SITE_URL']);
    define('CONTROLLER', $configuration['CONTROLLER']);
    define('MODEL', $configuration['MODEL']);
    define('ASSETS', $configuration['ASSETS']);
    define('DEFAULT_CONTROLLER', $configuration['DEFAULT_CONTROLLER']);
    define('KEY_AUTH', $configuration['KEY_AUTH']);
    define('BASE_URL_CREATIO', $configuration['BASE_URL_CREATIO']);
    define('USERNAME_CREATIO', $configuration['USERNAME_CREATIO']);
    define('PASSWORD_CREATIO', $configuration['PASSWORD_CREATIO']);
    define('USE_SQL_BUILDER', $configuration['USE_SQL_BUILDER']);
    define('DB_HOST', $configuration['DB_HOST']);
    define('DB_USERNAME', $configuration['DB_USERNAME']);
    define('DB_PASSWORD', $configuration['DB_PASSWORD']);
    define('DB_NAME', $configuration['DB_NAME']);
/** DONT CHANGE IT DIRECTLY */