<?php

    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Core;

    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../controllers/UserController.php';
    require_once __DIR__ . '/../controllers/ItemController.php';
    require_once __DIR__ . '/../controllers/TaskController.php';
    require_once __DIR__ . '/../controllers/InstController.php';
    require_once __DIR__ . '/security.php';

    // Les damos alias a sus namespace
    use App\Controllers\UserController as UserController;
    use App\Controllers\ItemController as ItemController;
    use App\Controllers\TaskController as TaskController;
    use App\Controllers\InstController as InstController;
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
            $instController = new InstController();
            
            switch ($this->route){
                case 'landing':
                    require __DIR__ . '/../views/index_view.php';
                    break;
                
                case 'core/logoff':
                    Security::logoff();
                    break;

                case 'user/index':

                    // Exclusivo para admin
                    Security::secureRoutes("Alta");
                    $userController->index();
                    break;

                case 'user/create':

                    Security::secureRoutes("Alta");
                    if($_SESSION["loginData"]["Privilegios"]==4){$insts=$instController->getAll();}
                    $userController->create($insts);
                    break;

                case 'user/edit':
                    // 10 es el owner, no editable bajo ninguna circunstancia
                    if($_GET["id"]==10){
                        header('Location: index.php?route=landing');
                    }else{
                        $userController->edit($this->id);
                    }
                    break;

                case 'user/delete':

                    Security::secureRoutes("Alta");
                    $userController->delete($this->id);
                    break;

                case 'user/manage':

                    Security::secureRoutes("Alta");

                    // Cada admin administra los permisos de su organización
                    if($_SESSION["loginData"]["Privilegios"]==4){header('Location: index.php?route=landing');}
                    $userController->bossManage($_SESSION["loginData"]["Id_Usuario"]);
                    break;

                case 'user/stats':
                    
                    Security::secureRoutes("Alta");
                    require __DIR__ . '/../views/user_stats.php';
                    break;
                    
                case 'item/index':

                    Security::secureRoutes("Media");
                    $itemController->index();
                    break;
    
                case 'item/create':

                    Security::secureRoutes("Alta");
                    $itemController->create();
                    break;
    
                case 'item/edit':

                    Security::secureRoutes("Media");
                    $itemController->edit($this->id);
                    break;
    
                case 'item/delete':

                    Security::secureRoutes("Media");
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

                case 'task/check' :
                    $taskController->check($this->id);
                    break;
        
                case 'task/delete':
                    $taskController->delete($this->id);
                    break;

                case 'inst/index':
                    Security::secureRoutes("Alta");
                    $instController->index();
                    break;

                case 'inst/create':
                    Security::secureRoutes("Alta");
                    $instController->create();
                    break;

                case 'inst/delete':
                    Security::secureRoutes("Alta");
                    $instController->delete($this->id);
                    break;
    
                default:
                    echo "Ruta no encontrada.";
                    die();
            }
        }

    }