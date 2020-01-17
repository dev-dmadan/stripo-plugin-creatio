<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

switch (ENVIRONMET) {
    case 'PROD':

        /**
         * Configuration URL
         */
        define('BASE_URL', 'http://localhost/iSystemAsia/stripo-plugin-creatio/');
        define('SITE_URL', 'http://localhost:8000/');
        define('CONTROLLER', ROOT.DS. 'app' .DS. 'controller' .DS);
        define('MODEL', ROOT.DS. 'app' .DS. 'model' .DS);
        define('ASSETS', BASE_URL. 'assets/');

        /**
         * Default Controller
         */
        define('DEFAULT_CONTROLLER', 'home');

        define('KEY_AUTH', '2a4a215c0f46c9fd8895e0840b0498ac');
        define('BASE_URL_CREATIO', '');
        define('USERNAME_CREATIO', '');
        define('PASSWORD_CREATIO', '');

        /**
         * Configuration Database
         */
        define('DB_HOST', '');
        define('DB_USERNAME', '');
        define('DB_PASSWORD', '');
        define('DB_NAME', '');

        break;
    case 'DEV-LIVE':

        /**
         * Configuration URL
         */
        define('BASE_URL', 'http://localhost/iSystemAsia/stripo-plugin-creatio/');
        define('SITE_URL', 'http://localhost:8000/');
        define('CONTROLLER', ROOT.DS. 'app' .DS. 'controller' .DS);
        define('MODEL', ROOT.DS. 'app' .DS. 'model' .DS);
        define('ASSETS', BASE_URL. 'assets/');

        /**
         * Default Controller
         */
        define('DEFAULT_CONTROLLER', 'home');

        define('KEY_AUTH', '2a4a215c0f46c9fd8895e0840b0498ac');
        define('BASE_URL_CREATIO', '');
        define('USERNAME_CREATIO', '');
        define('PASSWORD_CREATIO', '');

        /**
         * Configuration Database
         */
        define('DB_HOST', '');
        define('DB_USERNAME', '');
        define('DB_PASSWORD', '');
        define('DB_NAME', '');

        break;
    case 'DEV':
    default:
        
        /**
         * Configuration URL
         */
        define('BASE_URL', 'http://localhost/iSystemAsia/stripo-plugin-creatio/');
        define('SITE_URL', 'http://localhost:8000/');
        define('CONTROLLER', ROOT.DS. 'app' .DS. 'controller' .DS);
        define('MODEL', ROOT.DS. 'app' .DS. 'model' .DS);
        define('ASSETS', BASE_URL. 'assets/');

        /**
         * Default Controller
         */
        define('DEFAULT_CONTROLLER', 'home');

        define('KEY_AUTH', '2a4a215c0f46c9fd8895e0840b0498ac');
        define('BASE_URL_CREATIO', 'http://localhost:8083');
        define('USERNAME_CREATIO', 'Supervisor');
        define('PASSWORD_CREATIO', 'Supervisor');

        /**
         * Configuration Database
         */
        define('DB_HOST', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'dev-stripo');

        break;
}