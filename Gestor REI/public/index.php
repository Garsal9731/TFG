<?php

    // Definimos el namespace Public
    namespace App\Public;

    echo "Check 1<br>";
    require_once __DIR__ . '/../app/controllers/UserController.php';
    require_once __DIR__ . '/../app/controllers/NoteController.php';
    echo "Check 2<br>";

    use App\Controllers\UserController as UserController;
    use App\Controllers\NoteController as NoteController;

    echo "Check 3<br>";



    // Obtener la ruta
    $route = $_GET['route'] ?? 'user/index';
    $id = $_GET['id'] ?? null;
    echo "Check 4<br>";

    $userController = new UserController();
    echo "Check 4,5<br>";

    $noteController = new NoteController();
    echo "Check 5<br>";

    // Controlador frontal que maneja la ruta
    switch ($route){
        case 'user/index':
            $userController->index();
            break;

        case 'note/index':
            $noteController->index();
            break;

        case 'user/create':
            $userController->create();
            break;

        case 'note/create':
            $noteController->create();
            break;

        case 'user/edit':
            $userController->edit($id);
            break;

        case 'note/edit':
            $noteController->edit($id);
            break;

        case 'user/delete':
            $userController->delete($id);
            break;

        case 'note/delete':
            $noteController->delete($id);
            break;

        default:
            echo "Ruta no encontrada.";
    }
    echo "Check 6<br>";
