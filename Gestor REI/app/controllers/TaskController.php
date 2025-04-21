<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo tarea
    require_once __DIR__ . '/../models/Task.php';

    use App\Models\Task as Task;

    class TaskController {
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

        // Indice
        /**
         * @param VOID NULL
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los usuarios
         */ 
        public function index() {

            $tasks = $this->getAll();

            require __DIR__ . '/../views/task_list.php';
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
                $fechaEstimada = str_replace("T"," ",$_POST["fechaEstimada"]).":00";
                $this->taskModel->create(['Id_Creador_Tarea' => $idCreador,'Fecha_Creación' => $fechaCreacion,'Tiempo_Estimado' => $fechaEstimada,'Nombre_Tarea' => $_POST["nombreTarea"],'Detalles' => $_POST["detalles"]]);
                $lastId = $this->taskModel->getLastId();

                foreach($_POST["empleado"] as $employeeId){
                    $this->taskModel->asignUser($lastId,$employeeId);
                }

                header('Location: index.php?route=task/index');
            } else {
                $employees = $this->taskModel->getEmployees($_SESSION["loginData"]["Id_Usuario"]);
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
                var_dump($_POST);
                // $this->taskModel->update(['Nombre' => $_POST['nombre']], $id);
                // header('Location: index.php?route=task/index');
            } else {
                $task = $this->taskModel->getById($id);
                $employees = $this->taskModel->getEmployeesByTask($id);
                require __DIR__ . '/../views/task_edit.php';
            }
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
    }
