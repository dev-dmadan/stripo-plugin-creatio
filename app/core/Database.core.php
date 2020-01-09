<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class Database {

    public $connection;

    public function __construct() {
        $this->open();
    }

    /**
     * 
     */
    private function open() {
        try {
            $this->connection = new PDO("mysql:host={DB_HOST};dbname={DB_NAME}", DB_USERNAME, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            die(json_encode(array(
                'success' => false,
                'message' => 'Fail Connection to Database',
                'error' => $e->getMessage()
            )));
        }
    }

    /**
     * 
     */
    public function close() {
        $this->connection = null;
    }
}