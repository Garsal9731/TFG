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
                // $this->taskModel->create(['Nombre' => $_POST['nombre'],'Contraseña' => $cifrado,'Correo' => $_POST['correo'],'Privilegios' => $_POST["privilegios"]]);
                // header('Location: index.php?route=Task/index');
            } else {
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
                // $this->taskModel->update(['Nombre' => $_POST['nombre']], $id);
                header('Location: index.php?route=task/index');
            } else {
                // $Task = $this->taskModel->getById($id);
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
            // $this->taskModel->delete($id);
            header('Location: index.php?route=task/index');
        }
    }
