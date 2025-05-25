<?php

    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Core;

    session_start();

    require_once __DIR__ . '/../controllers/UserController.php';
    use App\Controllers\UserController as UserController;

    class Security {
        public static function login($data){
            $userController = new UserController();
            $userData = $userController->getByMail($data["correo"]);

            if(password_verify($data["contra"],$userData["Contraseña"])){
                $_SESSION["loginData"] = $userData;
                header('Location: index.php?route=landing');
                die();
            }else{
                Security::generateErrors("login");
                return false;
            }
        }

        public static function logoff(){
            session_destroy();
            header('Location: index.php');
        }

        public static function secureRoutes($seguridad){

            // Le especificamos el tipo de permiso que queremos filtrar
            switch ($seguridad) {
                case 'Alta':

                    // Exclusivo Admin
                    if($_SESSION["loginData"]["Privilegios"]!==1 && $_SESSION["loginData"]["Privilegios"]!==4){ header('Location: index.php?route=landing');}
                    break;
                case 'Media':
                    
                    // Si los permisos son de usuario normal no deja entrar
                    if($_SESSION["loginData"]["Privilegios"]==3){ header('Location: index.php?route=landing');}
                    break;
            }
        }

        public static function generateErrors($error){
            switch ($error) {
                case 'login':
                    echo "<p id='mensajeError' hidden>"."Usuario O Contraseña Invalida"."</p>";
                    break;

                case 'consulta':
                    echo "<p id='mensajeError' hidden>"."No se ha podido realizar la consulta"."</p>";
                    break;
                
                default:
                    echo "<p id='mensajeError' hidden>".$error."</p>";
                    break;
            }
        }
    }