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

        /**
         * Constructor Tareas
         * 
         * El constructor crea una nueva tarea usando el modelo Tarea.
         *
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            $this->taskModel = new Task();
        }

        /**
         * Recoger Todas las tareas.
         * 
         * Recogemos todas las tareas y las devolvemos en un array.
         * 
         * @param void
         * 
         * @return array $tasks Array con todas las tareas.
         */
        public function getAll(){
            $tasks = $this->taskModel->getAll();
            return $tasks;
        }

        /**
         * Busqueda Ajax
         * 
         * Recoge las tareas del usuario en funcion a si están completas o no y a el nombre de la tarea.
         * 
         * @param string $peticion Petición a buscar con el ajax.
         * @param int $idUser Id del usuario, usada para filtrar los resultado a tareas que se hayan asignado a este usuario.
         * @param string $status Estado de la tarea.
         * 
         * @return array $tasks Array con los resultados del ajax.
         */
        public function ajax($peticion,$idUser,$status){
            $tasks = $this->taskModel->ajax($peticion,$idUser,$status);
            return $tasks;
        }

        /**
         * Indice Tareas
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los usuarios.
         * 
         * @param void
         * 
         * @return void
         */ 
        public function index() {
            require __DIR__ . '/../views/task_list.php';
        } 

        /**
         * Tareas Completadas
         * 
         * Vista de tareas completadas.
         * 
         * @param void
         * 
         * @return void
         */ 
        public function completed() {
            require __DIR__ . '/../views/task_done.php';
        }

        /**
         * Tareas Creadas
         * 
         * Vista de tareas creadas.
         * @param void
         * 
         * @return void
         */ 
        public function created() {
            require __DIR__ . '/../views/task_created.php';
        }

        /**
         * Crear Tarea
         * 
         * Recogemos los datos del POST y los registramos como una nueva tarea en la base de datos.
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param void
         * 
         * @return void
         */ 
        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idCreador = $_SESSION["loginData"]["Id_Usuario"];
                $fechaCreacion = date("Y-m-d");
                $fechaEstimada = str_replace("T"," ",$_POST["fechaEstimada"]);

                $this->taskModel->create(['Id_Creador_Tarea' => $idCreador,'Fecha_Creación' => $fechaCreacion,'Tiempo_Estimado' => $fechaEstimada,'Nombre_Tarea' => $_POST["nombreTarea"],'Detalles' => $_POST["detalles"],'Estado' => $_POST["estado"]]);
                
                // Recogemos la ultima ID de las tareas que se haya registrado, en este caso será la de la tarea que acabamos de crear
                $lastId = $this->taskModel->getLastId();

                foreach($_POST["empleados"] as $employeeId){
                    $this->taskModel->assignUser($lastId["Id_Tarea"],$employeeId);
                }

                // Creamos una cookie para mandar el aviso de que se ha creado la tarea
                setcookie("status", "creado", time() + (86400 * 30), "/");
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

        /**
         * Editar Tarea
         * 
         * Usamos la id de la tarea para sobreescribir su registro en la base de datos con los datos recogidos del formulario.
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param int $id Id de la tarea que vamos a editar.
         * 
         * @return void
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

                // Creamos una cookie para mandar el aviso de que se ha modificado la tarea
                setcookie("status", "mod", time() + (86400 * 30), "/");

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

        /**
         * Comprobar Tarea
         * 
         * Usando la Id de la tarea para recoger los usuarios que la tienen asignada, mostrandolos en la vista.
         * 
         * @param int $id Id de la tarea que vamos a comprobar.
         * 
         * @return void
         */
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

        /**
         * Borrar Tarea
         * 
         * Usamos el metodo borrar del EmptyModel y borramos el registro usando la id.
         * 
         * @param int $id Id de la tarea a borrar.
         * 
         * @return void
         */
        public function delete($id) {
            $this->taskModel->delete($id);

            // Creamos una cookie para mandar el aviso de que se ha borrado la tarea
            setcookie("status", "borrado", time() + (86400 * 30), "/");
            header('Location: index.php?route=task/index');
        }

        /**
         * Recoger Tareas Asignadas
         * 
         * Usando la id del usuario recogemos las tareas que se le han asignado.
         * 
         * @param int $iduser Id del usuario activo.
         * 
         * @return array Array de las tareas asignadas al usuario.
         */
        public function getAssigned($idUser){
            return $this->taskModel->getAssigned($idUser);
        }

        /**
         * Recoger Tareas Creadas
         * 
         * Recoge las tareas que ha creado el usuario
         * 
         * @param int $userId Id del usuario.
         * 
         * @return array Array con las tareas que se le ha creado al usuario.
         */
        public function getCreated($userId){
            $tareas = $this->taskModel->getCreated($userId);
            require __DIR__ . '/../views/task_all.php';
        }
    }
