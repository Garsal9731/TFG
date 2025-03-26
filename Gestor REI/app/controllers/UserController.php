<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo User
    require_once __DIR__ . '/../models/User.php';

    use App\Models\User as User;

    class UserController {

        private $userModel;

        public function __construct() {
            $this->userModel = new User();
        }

        public function index() {
            $users = $this->userModel->getAll();

            // ? La ruta simplificada empieza desde la pagina inicial, (/public/index.php)
            // require "../app/views/user_list.php";
            require __DIR__ . '/../views/user_list.php';
        }

        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->userModel->create(['name' => $_POST['name']]);
                header('Location: index.php?route=user/index');
            } else {
                require __DIR__ . '/../views/user_create.php';
            }
        }

        public function edit($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->userModel->update(['name' => $_POST['name']], $id);
                header('Location: index.php?route=user/index');
            } else {
                $user = $this->userModel->getById($id);
                require __DIR__ . '/../views/user_edit.php';
            }
        }

        public function delete($id) {
            $this->userModel->delete($id);
            header('Location: index.php?route=user/index');
        }
    }
