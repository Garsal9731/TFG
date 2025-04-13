<?php

    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Core;

    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../controllers/UserController.php';
    require_once __DIR__ . '/../controllers/ItemController.php';
    require_once __DIR__ . '/../controllers/TaskController.php';

    // Les damos alias a sus namespace
    use App\Controllers\UserController as UserController;
    use App\Controllers\ItemController as ItemController;
    use App\Controllers\TaskController as TaskController;

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
            $this->route = $_GET['route'] ?? 'core/index';
            $this->id = $_GET['id'] ?? null;
        }

        // ! REVISAR INDEX Y EMPEZAR CON BOCETOS
        public function index(){
            $userController = new UserController();
            $itemController = new ItemController();
            $taskController = new TaskController();

            $users = $userController->getAll();
            $items = $itemController->getAll();
            $tasks = $taskController->getAll();
            require __DIR__ . '/../views/index_view.php';
        }

        // Enrutador
        /**
         * 
         * Usa la ruta y la id para llamar a las metodos de los controladores
         */
        public function enroute(){
            
            // Creamos nuevos controladores como objetos y los metemos en variables
            $userController = new UserController();
            $itemController = new ItemController();
            $taskController = new TaskController();
            
            switch ($this->route){
                case 'core/index':
                        $this->index();
                    break;

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
                    
                case 'item/index':
                    $itemController->index();
                    break;
    
                case 'item/create':
                    $itemController->create();
                    break;
    
                case 'item/edit':
                    $itemController->edit($this->id);
                    break;
    
                case 'item/delete':
                    $itemController->delete($this->id);
                    break;

                case 'task/index':
                    $taskController->index();
                    break;
        
                case 'task/create':
                    $taskController->create();
                    break;
        
                case 'task/edit':
                    $taskController->edit($this->id);
                    break;
        
                case 'task/delete':
                    $taskController->delete($this->id);
                    break;
    
                default:
                    echo "Ruta no encontrada.";
            }
        }

    }