<?php

    // ! Crear una clase para el enrutador en el core y llamarla aquí
    

    // Definimos el namespace Public
    namespace App\Public;

    // Llamamos a los controladores que vamos a usar
    require_once __DIR__ . '/../app/controllers/UserController.php';

    // Les damos alias a sus namespace
    use App\Controllers\UserController as UserController;

    // Obtener la ruta
    $route = $_GET['route'] ?? 'user/index';
    $id = $_GET['id'] ?? null;

    // Creamos nuevos controladores como objetos y los metemos en variables
    $userController = new UserController();

    // Controlador frontal que maneja la ruta
    // Enrutador
    /**
     * @param $ruta string
     * 
     * Usa la ruta para mostrar una de las vistas o llamar a uno de los metodos en los controladores
     */
    switch ($route){
        case 'user/index':
            $userController->index();
            break;

        case 'user/create':
            $userController->create();
            break;

        case 'user/edit':
            $userController->edit($id);
            break;

        case 'user/delete':
            $userController->delete($id);
            break;

        default:
            echo "Ruta no encontrada.";
    }

