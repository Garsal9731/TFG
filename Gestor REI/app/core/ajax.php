<?php
  
  // Ponemos el namespace y los alias de los namespace que vamos a utilizar
  namespace App\Core;
  use App\Controllers\UserController as UserController;
  use App\Controllers\ItemController as ItemController;
  use App\Controllers\TaskController as TaskController;
  use App\Controllers\InstController as InstController;

  // Recogemos la petición enviada y la tabla por GET
  $peticion = $_GET["peticion"];
  $tabla = $_GET["tabla"];

  // Preestablecemos el resultado para evitar errores
  $resultado = "";

  // Ya que el buscador de las tablas tiene las mismas dependencias pero cambia la query usada vamos a filtrar segun la letra para saber si son tareas Pendientes o Completadas
  if($tabla=="TareaP"||$tabla=="TareaC"||$tabla=="TareaD"||$tabla=="TareaU"){

    session_start();
    $array = str_split($tabla,5);
    $tabla = $array[0];
    $letra = $array[1];
  }

  // Usando la tabla pasada por parametro recogemos los recursos necesarios para hacer las consultas que queremos recoger con el Ajax 
  switch ($tabla) {
    case 'Usuario':
        require_once __DIR__.'/../controllers/UserController.php';
        
        // Usando una función con un SQL preparado buscamos la petición en la base de datos y la propia petición nos la devuelve
        $userController = new UserController();
        $users = $userController->ajaxMail($peticion);
        $resultado = $users;
      break;

    case 'Permisos':
        require_once __DIR__.'/../controllers/UserController.php';
        
        $userController = new UserController();
        
        // Recogemos la info de la institución a la que pertenece el usuario y sacamos su ID para usarla en la query de los permisos
        $instInfo = $userController->getUserInst($_SESSION["loginData"]["Id_Usuario"]);
        $idInst = $instInfo["Id_Institución"];

        $permits = $userController->getPermits($idInst,$peticion);
        $resultado = $permits;
      break;

    case 'Objeto' :
        require_once __DIR__.'/../controllers/ItemController.php';
        $itemController = new ItemController();
        $items =  $itemController->ajaxObjetos($peticion);
        $resultado = $items;
      break;
    
    case 'Tarea' :
        require_once __DIR__.'/../controllers/TaskController.php';
        $taskController = new TaskController();

        if(isset($_COOKIE["userSearch"])){
          $idUsuario = $_COOKIE["userSearch"];
          setcookie("userSearch", "", time() - 3600, "/");
        }else{
          $idUsuario = $_SESSION["loginData"]["Id_Usuario"];
        }

        // Mandamos al ajax la petición junto a la id del usuario y la letra para filtrar si la tarea a sido completada o no
        $tasks = $taskController->ajax($peticion,$idUsuario,$letra);
        $resultado = $tasks;
        break;
    case 'Institucion' :
        require_once __DIR__.'/../controllers/InstController.php';
        $instController = new InstController();
        $insts = $instController->ajax($peticion);
        $resultado = $insts;
      break;
  }

  // Codificamos el resultado en JSON y lo "enviamos" para recogerlo con la promesa en JS
  echo json_encode($resultado);