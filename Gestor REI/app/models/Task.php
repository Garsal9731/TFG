<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;

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
        public function assignUser($taskId,$employeeId){
            $sql = "INSERT INTO Tarea_Asignadas VALUES ($taskId,$employeeId);";
            $this->query($sql);
        }

        // Deasignar tarea a usuario
        /**
         * @param $taskId int
         * @param $employeeId int
         * 
         * Elimina la asignación de la tarea al usuario en la BD
         */
        public function removeUser($taskId,$employeeId){
            $sql = "DELETE FROM Tarea_Asignadas WHERE Tarea_Id_Tarea=$taskId AND Usuario_Id_Usuario=$employeeId;";
            $this->query($sql);
        }
        

        // Recoger usuarios de tarea
        /**
         * @param $idTask int
         * 
         * Usamos la id de la tarea para recoger los usuarios a los que se le han asignado
         */
        public function getEmployeesByTask($idTask){
            $sql = "SELECT Id_Usuario,Nombre FROM Usuario WHERE Id_Usuario IN (SELECT Usuario_Id_Usuario FROM Tarea_Asignadas WHERE Tarea_Id_Tarea=$idTask);";
            $employees = $this->query($sql)->fetchAll();
            return $employees;
        }

        // Comprobar si usuario está asignado
        /**
         * @param $taskId int
         * @param $employeeId int
         * 
         * Manda una consulta a la BD para revisar si el usuario está asignado a la tarea
         */
        public function checkIfAssigned($taskId,$employeeId){
            $sql = "SELECT * FROM Tarea_Asignadas WHERE Tarea_Id_Tarea=$taskId AND Usuario_Id_Usuario=$employeeId;";
            $query = $this->query($sql)->fetch();

            if($query==false){
                return false;
            }else{
                return true;
            }
        }
    }
