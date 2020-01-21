<?php
Defined('BASE_PATH') or die(ACCESS_DENIED);

class EmailModel extends Database {
    const useBuilder = true;
    const tableName = 'email';
    
    public $emailId;
    public $templateId;
    public $templateName;
    public $html;
    public $css;
    public $htmlFull;

    public function __construct() {
        parent::__construct(self::useBuilder);
    }
    
    /**
     * 
     */
    public function getAll() {

    }

    /**
     * 
     */
    public function insert() {

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
        
    }

    public function __destruct() {
        $this->close();
    }
}