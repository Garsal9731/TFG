<?php

    // Definimos el namespace Public
    namespace App\Public;

    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../app/core/Router.php';

    // Les damos alias al namespace
    use App\Core\Router as Router;

    session_start();
    $router = new Router();

    if(!isset($_COOKIE["session"]) || $_COOKIE["session"]==0){
        setcookie("session", 0, time() + (86400 * 30), "/");
        $_SESSION["loginData"] = null;
        require_once __DIR__ . '/../app/views/login.php';
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["loginData"]==null){
        $_SESSION["loginData"] = array('correo'=>$_POST["correo"],'contra'=>$_POST["contra"]);
    }

    switch ($_SESSION["loginData"]){
        case null:
            setcookie("session", 0, time() + (86400 * 30), "/");
            require_once __DIR__ . '/../app/views/login.php';
            break;

        case !null && $_COOKIE["session"]==0 :
            $router->login($_SESSION["loginData"]);
            break;

        default:
            $router->enroute();
    }