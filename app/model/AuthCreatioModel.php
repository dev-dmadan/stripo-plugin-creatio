<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

use ClanCats\Hydrahon\Query\Sql\Func as Func;
use ClanCats\Hydrahon\Query\Expression as Ex;

class AuthCreatioModel extends Database {

    const tableName = 'access_token';
    public $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->builder->table(self::tableName);
    }
    
    /**
     * 
     */
    public function getToken() {
        $success = false;
        $error = null;
        $result = null;

        try {
            $result = $this->auth->select(['token'])->limit(1)->get();
            $success = true;
        } 
        catch (PDOException $e) {
            $error = $e->getMessage();
        }
        
        return (object)array(
            'success' => $success,
            'data' => $success ? $result["token"] : null,
            'error' => $error
        );
    }

    public function __destruct() {
        $this->close();
    }
}