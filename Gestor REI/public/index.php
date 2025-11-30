<?php

    // Definimos el namespace Public
    namespace App\Public;

    session_start();
   
    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../app/core/Router.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../app/core/security.php';

    // Les damos alias al namespace
    use App\Core\Router as Router;
    use App\Core\Security as Security;

    $router = new Router();

    if($_SESSION["loginData"]==null){
        require_once __DIR__ . '/../app/views/login.php';
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["loginData"]==null && count($_POST)==2){
        $_SESSION["loginData"] = array('correo'=>$_POST["correo"],'contra'=>$_POST["contra"]);
    }

    switch ($_SESSION["loginData"]){
        case null:
            require_once __DIR__ . '/../app/views/login.php';
            break;

        case !null:
            if(count($_SESSION["loginData"])>2){
                $router->enroute();
            }else{
                if(!Security::login($_SESSION["loginData"])){
                    $_SESSION["loginData"] = null;
                }
            }
            break;
    }
    
    $time = 3600;
    if (isset($_SESSION['time']) && (time() - $_SESSION['time']) > $time) {
        header('location: core/logoff');
        exit();
    } else {
        $_SESSION['time'] = time();
    }
?>
<script src="JS/RecogidaError.js"></script>
<script src="JS/desplegableMovil.js"></script>