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

        public function login($data){
            $userController = new UserController();
            $userData = $userController->getByMail($data["correo"]);

            if(password_verify($data["contra"],$userData["Contraseña"])){
                $_SESSION["loginData"] = $userData;
                setcookie("session", 1, time() + (86400 * 30), "/");
                header('Location: index.php?route=core/index');
            }else{
                // ! AÑADIR RECOGIDA DE ERRORES EN CONDICIONES A JAVASCRIPT
                echo "Contraseña Invalida";
                // header('Location: index.php?route=core/index');
            }
        }

        public function logoff(){
            session_destroy();
            setcookie("session", 0, time() + (86400 * 30), "/");
            header('Location: index.php?route=core/index');
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
                    require __DIR__ . '/../views/index_view.php';
                    break;
                
                case 'core/logoff':
                    $this->logoff();
                    break;

                case 'user/index':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=core/index');}
                    $userController->index();
                    break;

                case 'user/create':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=core/index');}
                    $userController->create();
                    break;

                case 'user/edit':
                    $userController->edit($this->id);
                    break;

                case 'user/delete':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=core/index');}
                    $userController->delete($this->id);
                    break;

                case 'user/manage':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]!==1){ header('Location: index.php?route=core/index');}
                    $userController->bossManage($_SESSION["loginData"]["Id_Usuario"]);
                    break;
                    
                case 'item/index':

                    // Exclusivo para admin y tecnico
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=core/index');}
                    $itemController->index();
                    break;
    
                case 'item/create':

                    // Exclusivo para admin y tecnico
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=core/index');}
                    $itemController->create();
                    break;
    
                case 'item/edit':

                    // Exclusivo para admin y tecnico
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=core/index');}
                    $itemController->edit($this->id);
                    break;
    
                case 'item/delete':

                    // Exclusivo para admin
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=core/index');}
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