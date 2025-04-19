<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;

    // ! Añadir funciones extra de las tareas
    class Task extends EmptyModel {
    
        // Constructor
        /**
         * @param VOID NULL
         * 
         * Extiende el constructor de EmptyModel usando la tabla de Tarea como referencia
         */
        public function __construct() {
            parent::__construct('Tarea');
        }

        // Asignar tarea a usuario
        /**
         * @param $taskId int
         * @param $employeeId int
         * 
         * Registra a quien se le ha asignado la tarea en la BD
         */
        public function asignUser($taskId,$employeeId){
            $sql = "INSERT INTO Tarea_Asignadas VALUES ($taskId,$employeeId);";
            $this->query($sql);
        }
    }
