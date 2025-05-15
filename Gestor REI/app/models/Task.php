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
        
        // Recoger Usuarios Asignados
        /**
         * @param $userId int
         * 
         * Recoge las tareas que se le han asignado al usuario
         */
        public function getAssigned($userId){
            $sql = "SELECT * FROM Tarea WHERE Id_Tarea IN (SELECT Tarea_Id_Tarea FROM Tarea_Asignadas WHERE Usuario_Id_Usuario=$userId);";
            return $this->query($sql)->fetchAll();
        }

        // Busqueda Ajax
        /**
         * @param $peticion string
         * @param $idUser int
         * @param $status string
         * 
         * Recoge las tareas del usuario en funcion a si están completas o no y a el nombre de la tarea
         */
        public function ajax($peticion,$idUser,$status){

            if($status=="P"){
                $sql = "SELECT *  FROM Tarea INNER JOIN Tarea_Asignadas ON Id_Tarea=Tarea_Id_Tarea WHERE Nombre_Tarea LIKE '".$peticion."%' AND Estado='Pendiente' AND Usuario_Id_Usuario=".$idUser.";";
            }elseif($status=="C"){
                $sql = "SELECT *  FROM Tarea INNER JOIN Tarea_Asignadas ON Id_Tarea=Tarea_Id_Tarea WHERE Nombre_Tarea LIKE '".$peticion."%' AND Estado='Completada' AND Usuario_Id_Usuario=".$idUser.";";
            }else{
                $sql = "SELECT *  FROM Tarea INNER JOIN Tarea_Asignadas ON Id_Tarea=Tarea_Id_Tarea WHERE Nombre_Tarea LIKE '".$peticion."%' AND Usuario_Id_Usuario=".$idUser.";";
            }

            return $this->query($sql)->fetchAll();
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
