<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo tarea y traits
    require_once __DIR__ . '/../models/Task.php';
    require_once __DIR__ . '/../models/traits/getEmployees.php';
    require_once __DIR__ . '/../models/traits/getUserInst.php';
    require_once __DIR__ . '/../models/traits/getAllByInst.php';
    
    use App\Models\Task as Task;
    use App\Models\Traits\getEmployees as getEmployees;
    use App\Models\Traits\getUserInst as getUserInst;
    use App\Models\Traits\getAllByInst as getAllByInst;


    class TaskController {

        use getEmployees, getAllByInst, getUserInst;

        private $taskModel;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * El constructor crea una tarea nueva usando el constructor del controlador
         */
        public function __construct() {
            $this->taskModel = new Task();
        }

        // Recoger Todo
        /**
         * @param VOID NULL
         * 
         * Llamamos al modelo usuario y recogemos todos los usuarios 
         */
        public function getAll(){
            $tasks = $this->taskModel->getAll();
            return $tasks;
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
            $tasks = $this->taskModel->ajax($peticion,$idUser,$status);
            return $tasks;
        }

        // Indice
        /**
         * @param VOID NULL
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los usuarios
         */ 
        public function index() {

            if($_SESSION["loginData"]["Privilegios"]==1){
                $tasks = $this->getAll();
            }else{
                $tasks = $this->getAssigned($_SESSION["loginData"]["Id_Usuario"]);
            }

            require __DIR__ . '/../views/task_list.php';
        } 

        // Completadas
        /**
         * @param VOID NULL
         * 
         * Vista de tareas completadas
         */ 
        public function completed() {
            if($_SESSION["loginData"]["Privilegios"]==1){
                $tasks = $this->getAll();
            }else{
                $tasks = $this->getComplete($_SESSION["loginData"]["Id_Usuario"]);
            }

            require __DIR__ . '/../views/task_done.php';
        }

        // Crear 
        /**
         * @param VOID NULL
         * 
         * Usamos el metodo crear del EmptyModel y recogemos los datos por POST
         */ 
        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idCreador = $_SESSION["loginData"]["Id_Usuario"];
                $fechaCreacion = date("Y-m-d");
                $fechaEstimada = str_replace("T"," ",$_POST["fechaEstimada"]);

                $this->taskModel->create(['Id_Creador_Tarea' => $idCreador,'Fecha_Creación' => $fechaCreacion,'Tiempo_Estimado' => $fechaEstimada,'Nombre_Tarea' => $_POST["nombreTarea"],'Detalles' => $_POST["detalles"],'Estado' => $_POST["estado"]]);
                $lastId = $this->taskModel->getLastId();

                foreach($_POST["empleado"] as $employeeId){
                    $this->taskModel->assignUser($lastId,$employeeId);
                }

                header('Location: index.php?route=task/index');
            } else {
                if($_SESSION["loginData"]["Privilegios"]!==3){
                    $employees = $this->getEmployees($_SESSION["loginData"]["Id_Usuario"]);
                }else{
                    $employees = $this->getAllByInst($this->getUserInst($_SESSION["loginData"]["Id_Usuario"])["Id_Institución"]);
                }
                require __DIR__ . '/../views/task_create.php';
            }
        }

        // Editar
        /**
         * @param $id int
         * 
         * Usamos el metodo editar del EmptyModel, recogemos los datos por POST y le pasamos la id para actualizar el registro
         */

        public function edit($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Reformateamos la fecha para adaptarla al formato de la BD
                $fechaEstimada = str_replace("T"," ",$_POST["fechaEstimada"]).":00";
                
                // Actualizamos la tarea
                $this->taskModel->update(['Tiempo_Estimado' => $fechaEstimada,'Nombre_Tarea' => $_POST['nombreTarea'],'Detalles' => $_POST["detalles"]], $id);

                // Sacamos las ids de los empleados asignados a la tarea originalmente
                $assignedIds = array();
                foreach($this->taskModel->getEmployeesByTask($id) as $assignedEmployee){
                    array_push($assignedIds,$assignedEmployee["Id_Usuario"]);
                }

                // Diferenciamos los arrays y juntamos las diferencias en un solo array
                $diffEmployee = array_diff($assignedIds,$_POST["empleado"]);
                $employeeDiff = array_diff($_POST["empleado"],$assignedIds);
                $differences = array_merge($employeeDiff,$diffEmployee);

                // Comprobamos las diferencias y dependiendo de si están asignados los borramos, y al contrario los asignamos
                foreach($differences as $idDiff){
                    if($this->taskModel->checkIfAssigned($id,$idDiff)){
                        $this->taskModel->removeUser($id,$idDiff);
                    }else{
                        $this->taskModel->assignUser($id,$idDiff);
                    }
                }

                header('Location: index.php?route=task/index');
            } else {
                $task = $this->taskModel->getById($id);
                $employees = $this->getEmployees($_SESSION["loginData"]["Id_Usuario"]);

                $assignedEmployees = $this->taskModel->getEmployeesByTask($id);
                $idsAssigned = array();
                foreach($assignedEmployees as $idAssigned){
                    array_push($idsAssigned,$idAssigned["Id_Usuario"]);
                }
                require __DIR__ . '/../views/task_edit.php';
            }
        }

        public function check($id){
            $task = $this->taskModel->getById($id);
            $employees = $this->getEmployees($_SESSION["loginData"]["Id_Usuario"]);

            $assignedEmployees = $this->taskModel->getEmployeesByTask($id);
            $idsAssigned = array();
            foreach($assignedEmployees as $idAssigned){
                array_push($idsAssigned,$idAssigned["Id_Usuario"]);
            }
            require __DIR__ . '/../views/task_check.php';
        }

        // Borrar
        /**
         * @param $id int
         * 
         * Usamos el metodo borrar del EmptyModel y borramos el registro usando la id
         */
        public function delete($id) {
            $this->taskModel->delete($id);
            header('Location: index.php?route=task/index');
        }

        // Recoger Tareas Asignadas
        /**
         * @param $iduser int
         * 
         * Usando la id del usuario recogemos las tareas que se le han asignado
         */
        public function getAssigned($idUser){
            return $this->taskModel->getAssigned($idUser);
        }

        // Recoger Tareas Completadas
        /**
         * @param $iduser int
         * 
         * Usando la id del usuario recogemos las tareas que se han completado
         */
        public function getComplete($idUser){
            return $this->taskModel->getComplete($idUser);
        }
    }
