<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo Item
    require_once __DIR__ . '/../models/Item.php';

    use App\Models\Item as Item;

    class TaskController {
        private $itemModel;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * El constructor crea un item nuevo usando el constructor del item
         */
        public function __construct() {
            $this->itemModel = new Item();
        }

        // Indice
        /**
         * @param VOID NULL
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los usuarios
         */ 

        public function index() {

            // $items = $this->itemModel->getAll();

            require __DIR__ . '/../views/item_list.php';
        } 

        // Crear 
        /**
         * @param VOID NULL
         * 
         * Usamos el metodo crear del EmptyModel y recogemos los datos por POST
         */ 
        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // $this->itemModel->create(['Nombre' => $_POST['nombre'],'Contraseña' => $cifrado,'Correo' => $_POST['correo'],'Privilegios' => $_POST["privilegios"]]);
                // header('Location: index.php?route=item/index');
            } else {
                require __DIR__ . '/../views/item_create.php';
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
                // $this->itemModel->update(['Nombre' => $_POST['nombre']], $id);
                header('Location: index.php?route=item/index');
            } else {
                // $Item = $this->itemModel->getById($id);
                require __DIR__ . '/../views/item_edit.php';
            }
        }
        // Borrar
        /**
         * @param $id int
         * 
         * Usamos el metodo borrar del EmptyModel y borramos el registro usando la id
         */
        public function delete($id) {
            // $this->itemModel->delete($id);
            header('Location: index.php?route=item/index');
        }
    }
