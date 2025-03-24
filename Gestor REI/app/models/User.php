<?php

    // Definimos el namespace
    namespace App\Models;

    // ? Esto es lo mismo que require_once 'EmptyModel.php'
    require_once __DIR__ .'/./EmptyModel.php';

    // Le damos un alias a EmptyModel
    // use App\Models\EmptyModel as EmptyModel;
    class User extends EmptyModel {
        public function __construct() {
            parent::__construct('users');
        }
    }

