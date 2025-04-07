<?php

    // Definimos el namespace
    namespace App\Models;

    // ? Esto es lo mismo que require_once 'EmptyModel.php'
    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Models\EmptyModel as EmptyModel;
    
    class User extends EmptyModel {

        // Constructor
        /**
         * @param VOID NULL
         * 
         * Extiende el constructor de EmptyModel usando la tabla de usuarios como referencia
         */
        public function __construct() {
            parent::__construct('users');
        }
    }
