<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class Database {

    public $connection;
    public $builder;

    /**
     * 
     */
    public function __construct($useBuilder) {
        $this->open();
        if($useBuilder) {
            $connection = $this->connection;
            $this->builder = new \ClanCats\Hydrahon\Builder('mysql', 
                function($query, $queryString, $queryParameters) use($connection) {
                    $statement = $connection->prepare($queryString);
                    $statement->execute($queryParameters);

                    if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface) {
                        return $statement->fetchAll(\PDO::FETCH_ASSOC);
                    }
                }
            );
        }
    }

    /**
     * 
     */
    private function open() {
        try {
            $this->connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
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
    final public function close() {
        $this->connection = null;
    }
}