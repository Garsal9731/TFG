<?php

    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Core;

    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../controllers/UserController.php';

    // Les damos alias a sus namespace
    use App\Controllers\UserController as UserController;

    class Router {
        protected $route;
        protected $id;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * Es el constructor de la clase
         */
        public function __construct() {
            $this->route = $_GET['route'] ?? 'user/index';
            $this->id = $_GET['id'] ?? null;
        }

        // Enrutador
        /**
         * 
         * Usa la ruta y la id para llamar a las metodos de los controladores
         */
        public function enroute(){
            
            // Creamos nuevos controladores como objetos y los metemos en variables
            $userController = new UserController();
            
            switch ($this->route){
                // ! CAMBIAR RUTA INDICE Y HACER SU PROPIA VISTA
                case 'user/index':
                    $userController->index();
                    break;

                case 'user/create':
                    $userController->create();
                    break;

                case 'user/edit':
                    $userController->edit($this->id);
                    break;

                case 'user/delete':
                    $userController->delete($this->id);
                    break;

                default:
                    echo "Ruta no encontrada.";
            }
        }

    }