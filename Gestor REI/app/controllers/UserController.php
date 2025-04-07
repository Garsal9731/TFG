<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo User
    require_once __DIR__ . '/../models/User.php';

    use App\Models\User as User;

    class UserController {

        private $userModel;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * El constructor crea un usuario nuevo usando el constructor del usuario
         */
        public function __construct() {
            $this->userModel = new User();
        }

        // Indice
        /**
         * @param VOID NULL
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los usuarios
         */ 
        public function index() {

            $users = $this->userModel->getAll();

            // ? La ruta simplificada empieza desde la pagina inicial, (/public/index.php)
            // require "../app/views/user_list.php";
            require __DIR__ . '/../views/user_list.php';
        }

        // Crear 
        /**
         * @param VOID NULL
         * 
         * Usamos el metodo crear del EmptyModel y recogemos los datos por POST
         */ 
        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->userModel->create(['name' => $_POST['name']]);
                header('Location: index.php?route=user/index');
            } else {
                require __DIR__ . '/../views/user_create.php';
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
                $this->userModel->update(['name' => $_POST['name']], $id);
                header('Location: index.php?route=user/index');
            } else {
                $user = $this->userModel->getById($id);
                require __DIR__ . '/../views/user_edit.php';
            }
        }

        // Borrar
        /**
         * @param $id int
         * 
         * Usamos el metodo borrar del EmptyModel y borramos el registro usando la id
         */
        public function delete($id) {
            $this->userModel->delete($id);
            header('Location: index.php?route=user/index');
        }
    }
