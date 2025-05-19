<?php

    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Core;

    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../controllers/UserController.php';
    require_once __DIR__ . '/../controllers/ItemController.php';
    require_once __DIR__ . '/../controllers/TaskController.php';
    require_once __DIR__ . '/security.php';

    // Les damos alias a sus namespace
    use App\Controllers\UserController as UserController;
    use App\Controllers\ItemController as ItemController;
    use App\Controllers\TaskController as TaskController;
    use App\Core\Security as Security;

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
            $this->route = $_GET['route'] ?? 'landing';
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
            $itemController = new ItemController();
            $taskController = new TaskController();
            
            switch ($this->route){
                case 'landing':
                    require __DIR__ . '/../views/index_view.php';
                    break;
                
                case 'core/logoff':
                    Security::logoff();
                    break;

                case 'user/index':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=landing');}
                    $userController->index();
                    break;

                case 'user/create':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=landing');}
                    $userController->create();
                    break;

                case 'user/edit':
                    $userController->edit($this->id);
                    break;

                case 'user/delete':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=landing');}
                    $userController->delete($this->id);
                    break;

                case 'user/manage':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=landing');}
                    $userController->bossManage($_SESSION["loginData"]["Id_Usuario"]);
                    break;
                    
                case 'item/index':

                    // Exclusivo para admin y tecnico
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=landing');}
                    $itemController->index();
                    break;
    
                case 'item/create':

                    // Exclusivo para admin y tecnico
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=landing');}
                    $itemController->create();
                    break;
    
                case 'item/edit':

                    // Exclusivo para admin y tecnico
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=landing');}
                    $itemController->edit($this->id);
                    break;
    
                case 'item/delete':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=landing');}
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