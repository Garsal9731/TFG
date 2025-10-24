<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo objeto y traits
    require_once __DIR__ . '/../models/Inst.php';

    use App\Models\Inst as Inst;

    class InstController {

        private $instModel;

        /**
         * Constructor Instituciones
         * 
         * El constructor crea una nueva institución usando el modelo de institución como referencia.
         *
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            $this->instModel = new Inst();
        }

        /**
         * Recoger Instituciones
         * 
         * Recoger todas las instituciones.
         * 
         * @param void
         * 
         * @return array $insts Array con todas las instituciones creadas.
         */
        public function getAll(){
            $insts = $this->instModel->getAll();
            return $insts;
        }

        /**
         * Indice Instituciones
         * 
         * Vista con una lista de las instituciones existentes.
         * 
         * @param void
         * 
         * @return void
         */ 
        public function index() {
            require __DIR__ . '/../views/inst_list.php';
        }

        /**
         * Ajax Instituciones
         * 
         * Usamos la petición para buscar la institución por su nombre.
         * 
         * @param string $peticion Nombre de la institución.
         * 
         * @return array $data Datos de la institución buscados con el ajax.
         */
        public function ajax($peticion){
            $data = $this->instModel->ajaxInstitucion($peticion);
            return $data;
        }

        /**
         * Registrar Institución
         * 
         * Recogemos los datos del POST y los usamos para crear un nuevo registro en la base de datos.
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param void
         * 
         * @return void
         */
        public function create(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->instModel->create(['Nombre_Institución' => ucfirst($_POST["nombre"])]);
                                
                // Creamos una cookie para mandar el aviso de que se ha creado la institución
                setcookie("status", "creado", time() + (86400 * 30), "/");

                header('Location: index.php?route=inst/index');
            } else {
                require __DIR__ . '/../views/inst_create.php';
            }
        }

        /**
         * Borrar Institución
         * 
         * Usamos la Id de la institución para borrar su registro de la base de datos.
         * 
         * @param int $id Id de la institución que vamos a borrar.
         * 
         * @return void
         */
        public function delete($id) {
            $this->instModel->delete($id);

            // Creamos una cookie para mandar el aviso de que se ha borrado la institución
            setcookie("status", "borrado", time() + (86400 * 30), "/");
            header('Location: index.php?route=inst/index');
        }
    }