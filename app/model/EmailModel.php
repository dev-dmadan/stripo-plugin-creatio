<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

use ClanCats\Hydrahon\Query\Sql\Func as Func;
use ClanCats\Hydrahon\Query\Expression as Ex;

class EmailModel extends Database {
    const tableName = 'email';
    public $email;

    public function __construct() {
        parent::__construct();
        $this->email = $this->builder->table(self::tableName);
    }

    /**
     * 
     */
    public function select($column, $conditional = null) {
        $success = false;
        $error = null;
        $result = null;

        try {
            $q = $this->email->select();
            
            if(is_array($column) && count($conditional) > 0) {
                $column_ = array();
                foreach($column as $value) {
                    $column_[] = $value;
                }
                $q->fields($column_);
            }
            else if(is_string($column)) {
                $q->fields([$column]);
            }

            if(is_array($conditional) && count($conditional) > 0) {
                foreach($conditional as $key => $value) {
                    $q->where($key, $value);
                }
            }

            $result = $q->get();
            $success = true;
        } 
        catch (PDOException $e) {
            $error = $e->getMessage();
        }
        
        return (object)array(
            'success' => $success,
            'data' => $result,
            'error' => $error
        );
    }

    /**
     * 
     */
    public function insert($data) {
        $success = false;
        $error = null;

        try {
            $this->connection->beginTransaction();
            
            $this->email->insert($data)->execute();

            $this->connection->commit();
            $success = true;
        }
        catch (PDOException $e) {
            $this->connection->rollBack();
            $error = $e->getMessage();
        }

        return (object)array(
            'success' => $success,
            'error' => $error
        );
    }

    /**
     * 
     */
    public function update() {

    }

    /**
     * 
     */
    public function delete() {

    }
    
    /**
     * 
     */
    public function getCount($column, $conditional = null) {
        $success = false;
        $error = null;
        $result = null;

        $column_ = is_array($column) ? array_keys($column)[0] : $column;
        $alias = is_array($column) ? array_values($column)[0] : $column;

        try {
            $q = $this->email->select(new Ex('count('.$column_.') as '. $alias));
        
            if(is_array($conditional) && count($conditional) > 0) {
                foreach($conditional as $key => $value) {
                    $q->where($key, $value);
                }
            }

            $result = (int)$q->get()[0][$alias];
            $success = true;
        } 
        catch (PDOException $e) {
            $error = $e->getMessage();
        }
        
        return (object)array(
            'success' => $success,
            'data' => $result,
            'error' => $error
        );
    }

    /**
     * 
     */
    public function generateId() {
        $success = false;
        $error = null;
        $result = null;

        $query = "SELECT f_get_increment() increment";
        try {
            $this->connection->beginTransaction();

            $result = (int)$this->email->select(new Ex('f_get_increment() as increment'))->get()[0]['increment'];

            $this->connection->commit();
            $success = true;
        } 
        catch (PDOException $e) {
            $this->connection->rollBack();
            $error = $e->getMessage();
        }

        return (object)array(
            'success' => $success,
            'data' => $result,
            'error' => $error
        );
    }

    public function __destruct() {
        $this->close();
    }
}