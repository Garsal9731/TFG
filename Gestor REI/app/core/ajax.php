<?php
  
  // Ponemos el namespace y los alias de los namespace que vamos a utilizar
  namespace App\Core;
  use App\Controllers\UserController as UserController;

  // Recogemos la petición enviada y la tabla por GET
  $peticion = $_GET["peticion"];
  $tabla = $_GET["tabla"];

  // Preestablecemos el resultado para evitar errores
  $resultado = "";

  // Usando la tabla pasada por parametro recogemos los recursos necesarios para hacer las consultas que queremos recoger con el Ajax 
  switch ($tabla) {
    case 'Usuario':
        require_once __DIR__.'/../controllers/UserController.php';
        
        // Usando una función con un SQL preparado buscamos la petición en la base de datos y la propia petición nos la devuelve
        $userController = new UserController();
        $users = $userController->ajaxMail($peticion);
        $resultado = $users;
      break;
  }

  // Codificamos el resultado en JSON y lo "enviamos" para recogerlo con la promesa en JS
  echo json_encode($resultado);