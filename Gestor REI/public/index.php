<?php

    // Definimos el namespace Public
    namespace App\Public;

    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../app/core/Router.php';

    // Les damos alias al namespace
    use App\Core\Router as Router;

    $router = new Router();
    $router->enroute();