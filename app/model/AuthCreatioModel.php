<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class AuthCreatioModel extends Database {

    private $connection;

    public function __construct() {
        $this->connection = $this->open();
    }
    
}