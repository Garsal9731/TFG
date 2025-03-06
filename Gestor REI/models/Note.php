<?php
require_once 'models/EmptyModel.php';

class Note extends EmptyModel {

    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $fields = ['content', 'user_id', 'nota'];  // Agregamos 'nota'

    public function __construct() {
        parent::__construct($this->table, $this->primaryKey, $this->fields);
    }

}

?>