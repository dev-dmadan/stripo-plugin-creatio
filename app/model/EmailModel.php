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
     * Method select
     * @param {array / string} column
     * @param {array} conditional
     * @return {object} result
     *              success {boolean}
     *              error {string}
     *              data {array}
     */
    public function select($column, $conditional = null) {
        $success = false;
        $error = null;
        $result = null;

        try {
            $q = $this->email->select();
            
            if(is_array($column) && count($column) > 0) {
                $q->fields($column);
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
     * Method insert
     * @param {array} data
     * @return {object} result
     *              success {boolean}
     *              error {string}
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
     * Method update
     * @param 
     */
    public function update($data, $conditional) {
        $success = false;
        $error = null;
        $result = null;

        try {
            $q = $this->email->update();
            
            if(is_array($data) && count($data) > 0) {
                $q->set($data);
            }

            if(is_array($conditional) && count($conditional) > 0) {
                foreach($conditional as $key => $value) {
                    $q->where($key, $value);
                }
            }

            $result = $q->execute();
            $success = true;
        } 
        catch (PDOException $e) {
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

            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = (int)$statement->fetch(PDO::FETCH_ASSOC)['increment'];

            $statement->closeCursor();
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

    public function getStripo() {
        $success = false;
        $error = null;
        $result = null;

        $query = "SELECT id_bpm, html, css FROM email WHERE isTemplate != 1 AND ";
        $query .= "(html IS NOT NULL AND html != '') AND ";
        $query .= "(css IS NOT NULL AND css != '') AND ";
        $query .= "(html_css IS NULL OR html_css = '')";

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    public function __destruct() {
        $this->close();
    }
}