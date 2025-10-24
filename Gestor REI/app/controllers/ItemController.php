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

        /**
         * Constructor Objetos
         * 
         * El constructor crea un nuevo objeto usando como base el modelo de objetos.
         *
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            $this->itemModel = new Item();
        }

        /**
         * Recoger todos los objetos.
         * 
         * Recogemos todos los objetos.
         * 
         * @param void
         * 
         * @return array $items Array con todos los objetos.
         */
        public function getAll(){
            return $items;
        }

        /**
         * Indice Objetos
         * 
         * Vista del indice de los objetos.
         * 
         * @param void
         * 
         * @return void
         */ 
        public function index() {
            require __DIR__ . '/../views/item_list.php';
        }

        /**
         * Ajax Objetos
         * 
         * Filtramos el objeto buscandolo por su nombre y la institución del usuario activo.
         * 
         * @param string $peticion Nombre del objeto que vamos a buscar.
         * 
         * @return array $data Array con los datos del objeto. 
         */
        public function ajaxObjetos($peticion){
            $idInst = $this->getUserInst($_SESSION["loginData"]["Id_Usuario"])["Id_Institución"];
            $data = $this->itemModel->ajaxObjetos($peticion,$idInst);
            return $data;
        }

        /**
         * Crear Objeto
         * 
         * Recogemos los datos del formulario y los usamos para crear un nuevo registro en la base de datos.
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param void
         * 
         * @return void
         */ 
        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idUser = $_SESSION["loginData"]["Id_Usuario"]; 
                $idInst = $this->getUserInst($idUser)["Id_Institución"];
                $this->itemModel->create(['Nombre' => $_POST['nombre'],'Estado' => $_POST["estado"],'Descripción_Avería' => $_POST['descAveria'],'Institución_Id_Institución' => $idInst]);

                // Creamos una cookie para mandar el aviso de que se ha creado el objeto
                setcookie("status", "creado", time() + (86400 * 30), "/");
                header('Location: index.php?route=item/index');
            } else {
                require __DIR__ . '/../views/item_create.php';
            }
        }

        /**
         * Editar Objeto
         * 
         * Recogemos los datos del formulario y usando la Id del objeto reescribimos su registro en la base de datos.
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param int $id
         * 
         * @return void
         */

        public function edit($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                settype($id, "int");
                $this->itemModel->update(['Nombre' => $_POST['nombre'],'Estado'=>$_POST['estado'],'Descripción_Avería'=>$_POST['descAveria']], $id);
                
                // Creamos una cookie para mandar el aviso de que se ha modificado el objeto
                setcookie("status", "mod", time() + (86400 * 30), "/");
                header('Location: index.php?route=item/index');
            } else {
                $item = $this->itemModel->getById($id);
                require __DIR__ . '/../views/item_edit.php';
            }
        }

        /**
         * Borrar Objeto
         * 
         * Usamos la Id del objeto para borrarlo y creamos una cookie de aviso.
         * 
         * @param int $id Id del objeto a borrar.
         * 
         * @return void
         */
        public function delete($id) {
            $this->itemModel->delete($id);

            // Creamos una cookie para mandar el aviso de que se ha borrado el objeto
            setcookie("status", "borrado", time() + (86400 * 30), "/");
            header('Location: index.php?route=item/index');
        }
    }
