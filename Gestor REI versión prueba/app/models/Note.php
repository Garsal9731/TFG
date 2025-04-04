<?php

    // Instanciamos el namespace
    namespace App\Models;

    // ? Esto es lo mismo que require_once 'EmptyModel.php'
    require_once __DIR__ .'/./EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Models\EmptyModel as EmptyModel;

    class Note extends EmptyModel {

        protected $table = 'notes';
        protected $primaryKey = 'id';
        protected $fields = ['content', 'user_id', 'nota'];  // Agregamos 'nota'

        public function __construct() {
            parent::__construct($this->table, $this->primaryKey, $this->fields);
        }

    }
