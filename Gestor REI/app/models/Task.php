<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Models\EmptyModel as EmptyModel;

    // ! Añadir funciones extra de las tareas
    class Task extends EmptyModel {
    
        // Constructor
        /**
         * @param VOID NULL
         * 
         * Extiende el constructor de EmptyModel usando la tabla de Tarea como referencia
         */
    }
