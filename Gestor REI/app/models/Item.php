<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Models\EmptyModel as EmptyModel;

    // ! Añadir funciones extras de los objetos
    class Item extends EmptyModel {
    
        // Constructor
        /**
         * @param VOID NULL
         * 
         * Extiende el constructor de EmptyModel usando la tabla de objeto como referencia
         */
    }
