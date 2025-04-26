<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo objeto y traits
    require_once __DIR__ . '/../models/Item.php';
    require_once __DIR__ . '/../models/traits/getUserInst.php';

    use App\Models\Item as Item;
    use App\Models\Traits\getUserInst as getUserInst;

    class ItemController {

        use getUserInst;

        private $itemModel;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * El constructor crea un objeto nuevo usando el constructor del controlador
         */
        public function __construct() {
            $this->itemModel = new Item();
        }

        // Recoger Todo
        /**
         * @param VOID NULL
         * 
         * Llamamos al modelo objeto y recogemos todos los objetos 
         */
        public function getAll(){
            $items = $this->itemModel->getAll();
            return $items;
        }

        // Indice
        /**
         * @param VOID NULL
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los objetos
         */ 
        public function index() {

            $items = $this->getAll();

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
                $idUser = $_SESSION["loginData"]["Id_Usuario"]; 
                $idInst = $this->getUserInst($idUser)["Id_Institución"];
                $this->itemModel->create(['Nombre' => $_POST['nombre'],'Estado' => $_POST["estado"],'Descripción_Avería' => $_POST['descAveria'],'Institución_Id_Institución' => $idInst]);
                header('Location: index.php?route=item/index');
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
                settype($id, "int");
                $this->itemModel->update(['Nombre' => $_POST['nombre'],'Estado'=>$_POST['estado'],'Descripción_Avería'=>$_POST['descAveria']], $id);
                header('Location: index.php?route=item/index');
            } else {
                $item = $this->itemModel->getById($id);
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
            $this->itemModel->delete($id);
            header('Location: index.php?route=item/index');
        }
    }
