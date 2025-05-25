<?php

  namespace App\Core;
  use App\Controllers\TaskController as TaskController;

  require_once __DIR__.'/../controllers/TaskController.php';

  $taskController = new TaskController();

  // Recogemos la id del usuario pasada por JS y buscamos sus tareas
  $idUsuario = $_GET["id"];
  $tasks = $taskController->getAssigned($idUsuario);
  $resultado = $tasks;

  echo json_encode($resultado);