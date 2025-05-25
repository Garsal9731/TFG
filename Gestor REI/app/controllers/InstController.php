<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo objeto y traits
    require_once __DIR__ . '/../models/Inst.php';

    use App\Models\Inst as Inst;

    class InstController {


        private $instModel;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * El constructor crea un objeto nuevo usando el constructor del controlador
         */
        public function __construct() {
            $this->instModel = new Inst();
        }

        // Recoger Todo
        /**
         * @param VOID NULL
         * 
         * Llamamos al modelo objeto y recogemos todos los objetos 
         */
        public function getAll(){
            $insts = $this->instModel->getAll();
            return $insts;
        }

        // Indice
        /**
         * @param VOID NULL
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los objetos
         */ 
        public function index() {
            require __DIR__ . '/../views/inst_list.php';
        }

        // Buscamos con el ajax
        /**
         * @param $peticion string
         * 
         */
        public function ajax($peticion){
            $data = $this->instModel->ajaxInstitucion($peticion);
            return $data;
        }

        // Registramos la institución
        /**
         * 
         */
        public function create(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->instModel->create(['Nombre_Institución' => ucfirst($_POST["nombre"])]);

                header('Location: index.php?route=inst/index');
            } else {
                require __DIR__ . '/../views/inst_create.php';
            }
        }

        // Borrar
        /**
         * @param $id int
         * 
         * Usamos el metodo borrar del EmptyModel y borramos el registro usando la id
         */
        public function delete($id) {
            $this->instModel->delete($id);
            header('Location: index.php?route=inst/index');
        }
    }