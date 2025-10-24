<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;

    class Task extends EmptyModel {
    
        /**
         * Constructor Tarea
         * 
         * Extiende el constructor de EmptyModel usando la tabla de Tarea como referencia.
         * 
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            parent::__construct('Tarea');
        }

        /**
         * Asignar tarea a usuario
         * 
         * Registra a quien se le ha asignado la tarea en la base de datos.
         * 
         * @param int $taskId Id de la tarea a asignar.
         * @param int $employeeId Id del empleado al que se le va a asignar la tarea.
         * 
         * @return void
         */
        public function assignUser($taskId,$employeeId){
            $sql = "INSERT INTO Tarea_Asignadas VALUES ($taskId,$employeeId);";
            $this->query($sql);
        }

        /**
         * Recoger última Id
         * 
         * Recoge la id de la última tarea creada.
         * 
         * @param void
         * 
         * @return int $lastId Id de la última tarea creada. 
         */
        public function getLastId(){
            $sql = "SELECT Id_Tarea FROM Tarea ORDER BY Id_Tarea DESC LIMIT 1;";
            $lastId = $this->query($sql)->fetch();
            return $lastId;
        }

        /**
         * Recoger usando Id
         * 
         * Recoge la tarea usando la Id como referencia.
         * 
         * @param int $id Id de la tarea a buscar.
         * 
         * @return array Array con la información de la tarea. 
         */
        public function getById($id){
            $sql = "SELECT * FROM Tarea WHERE Id_Tarea=$id;";
            return $this->query($sql)->fetch();
        }

        /**
         * Deasignar tarea a usuario
         * 
         * Elimina la asignación de la tarea al usuario en la base de datos.
         * 
         * @param int $taskId Id de la tarea a deasignar.
         * @param int $employeeId Id del empleado a deasignar de la tarea.
         * 
         * @return void
         */
        public function removeUser($taskId,$employeeId){
            $sql = "DELETE FROM Tarea_Asignadas WHERE Tarea_Id_Tarea=$taskId AND Usuario_Id_Usuario=$employeeId;";
            $this->query($sql);
        }

        /**
         * Busqueda Ajax Tareas
         * 
         * Recoge las tareas del usuario en funcion a si están completas o no y a el nombre de la tarea.
         * 
         * @param string $peticion Nombre de la tarea.
         * @param int $idUser Id del usuario actual.
         * @param string $status Estado de la tarea, usado para filtrar usando consultas perparadas.
         * 
         * @return array Array con las tareas resultantes de la busqueda.
         */
        public function ajax($peticion,$idUser,$status){

            switch ($status) {
                case 'P':
                    $sql ="SELECT Id_Tarea,Nombre,Nombre_Tarea,Detalles FROM Tarea INNER JOIN Tarea_Asignadas ON Id_Tarea=Tarea_Id_Tarea INNER JOIN Usuario ON Id_Creador_Tarea=Id_Usuario WHERE Nombre_Tarea LIKE '".$peticion."%' AND Estado='Pendiente' AND Usuario_Id_Usuario=".$idUser.";";
                    break;
                case 'C':
                    $sql ="SELECT Id_Tarea,Nombre,Nombre_Tarea,Detalles FROM Tarea INNER JOIN Tarea_Asignadas ON Id_Tarea=Tarea_Id_Tarea INNER JOIN Usuario ON Id_Creador_Tarea=Id_Usuario WHERE Nombre_Tarea LIKE '".$peticion."%' AND Estado='Completada' AND Usuario_Id_Usuario=".$idUser.";";
                    break;
                case 'D':
                    $sql ="SELECT Id_Tarea,Nombre,Nombre_Tarea,Detalles FROM Tarea INNER JOIN Usuario ON Id_Creador_Tarea=Id_Usuario WHERE Id_Creador_Tarea=".$idUser." AND Nombre_Tarea LIKE '".$peticion."%' ORDER BY Estado DESC;";
                    break;
                default:
                    $sql ="SELECT Id_Tarea,Nombre_Tarea,Detalles FROM Tarea INNER JOIN Tarea_Asignadas ON Id_Tarea=Tarea_Id_Tarea INNER JOIN Usuario ON Id_Creador_Tarea=Id_Usuario WHERE Nombre_Tarea LIKE '".$peticion."%' AND Usuario_Id_Usuario=".$idUser.";";
                    break;
            }
            return $this->query($sql)->fetchAll();
        }

        /**
         * Recoger usuarios de tarea
         * 
         * Usamos la id de la tarea para recoger los usuarios a los que se le han asignado.
         * 
         * @param int $idTask Id de la tarea.
         * 
         * @return array $employees Array con los usuarios asignados a la tarea buscada.
         */
        public function getEmployeesByTask($idTask){
            $sql = "SELECT Id_Usuario,Nombre FROM Usuario WHERE Id_Usuario IN (SELECT Usuario_Id_Usuario FROM Tarea_Asignadas WHERE Tarea_Id_Tarea=$idTask);";
            $employees = $this->query($sql)->fetchAll();
            return $employees;
        }

        /**
         * Comprobar si usuario está asignado
         * 
         * Manda una consulta a la base de datos para revisar si el usuario está asignado a la tarea
         * 
         * @param int $taskId Id de la tarea asignada.
         * @param int $employeeId Id del empleado al que se le ha asignado la tarea.
         * 
         * @return bool Booleano que indica si se ha asignado la tarea anteriormente al usuario.
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

        /**
         * Recoger Tareas Asignadas
         * 
         * Recoge las tareas que se le han asignado al usuario.
         * 
         * @param int $userId Id del usuario.
         * 
         * @return array Array con las tareas que se le han asignado al usuario.
         */
        public function getAssigned($userId){
            $sql = "SELECT * FROM Tarea WHERE Id_Tarea IN (SELECT Tarea_Id_Tarea FROM Tarea_Asignadas WHERE Usuario_Id_Usuario=$userId);";
            return $this->query($sql)->fetchAll();
        }
    }
