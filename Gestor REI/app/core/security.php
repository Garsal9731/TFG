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
                // ! AÑADIR RECOGIDA DE ERRORES EN CONDICIONES A JAVASCRIPT
                echo "Usuario O Contraseña Invalida";
                return false;
            }
        }

        public static function logoff(){
            session_destroy();
            header('Location: index.php');
        }
    }