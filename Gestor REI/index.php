<?php
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/NoteController.php';

// Obtener la ruta
$route = $_GET['route'] ?? 'user/index';
$id = $_GET['id'] ?? null;

$userController = new UserController();
$noteController = new NoteController();

// Controlador frontal que maneja la ruta
switch ($route) {
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
