<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class EmailModel extends Database {
    const tableName = 'email';
    private $email;

    public function __construct() {
        parent::__construct();
        $this->email = $this->builder->table(self::tableName);
    }
    
    /**
     * 
     */
    public function getAll() {

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
    public function generateId() {
        $success = false;
        $error = null;

        $query = "SELECT f_get_increment() increment";
        try {
            $this->connection->beginTransaction();

            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

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

    public function __destruct() {
        $this->close();
    }
}