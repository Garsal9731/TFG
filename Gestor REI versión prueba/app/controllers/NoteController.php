<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo Note
    require_once __DIR__ . '/../models/Note.php';

    // Le damos un alias al namespace de la clase Note
    use App\Models\Note as Note;

    class NoteController {

        private $noteModel;

        public function __construct() {
            $this->noteModel = new Note();
        }

        public function index() {
            $notes = $this->noteModel->getAll();
            require 'views/note_list.php';
        }

        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->noteModel->create([
                    'content' => $_POST['content'],
                    'user_id' => $_POST['user_id'],
                    'nota' => $_POST['nota']  // Incluimos 'nota' en la creación
                ]);
                header('Location: index.php?route=note/index');
            } else {
                // Obtener los usuarios registrados para el formulario
                require_once 'models/User.php';
                $userModel = new User();
                $users = $userModel->getAll(); // Obtener todos los usuarios
                require 'views/note_create.php';
            }
        }

        public function edit($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->noteModel->update([
                    'content' => $_POST['content'],
                    'user_id' => $_POST['user_id'],
                    'nota' => $_POST['nota']  // Incluimos 'nota' en la edición
                ], $id);
                header('Location: index.php?route=note/index');
            } else {
                $note = $this->noteModel->getById($id);
                require 'views/note_edit.php';
            }
        }

        public function delete($id) {
            $this->noteModel->delete($id);
            header('Location: index.php?route=note/index');
        }
    }
