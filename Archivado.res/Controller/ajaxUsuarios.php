<?php

  // ! REUTILIZAR
  require '../Model/usuario.php';

  $resultadoBD = Usuario::getUsuarios();

    // Usamos el parametro peticion 
    $peticion = $_REQUEST["peticion"];

    $resultado = "";
  
    // Comprobamos el input de la peticion junto a los nombres de la base de datos para buscar similitudes
    if ($peticion !== "") {
      $peticion = strtolower($peticion);
      $longitud = strlen($peticion);
  
      foreach($resultadoBD as $usuario){
        $nombre = $usuario->getNombre();
        if (stristr($peticion, substr($nombre, 0, $longitud))) {
            $resultado ='<article class="tarjeta_usuario">
                <h3>'.$usuario->getNombre().'</h3>
                <p>Correo: '.$usuario->getCorreo().'</p>
                <a href="../Controller/darBajaUsuario.php?id='.$usuario->getId().'">Dar de baja</a>
            </article>';
        }
      }
    }
  
    // Si no encuentra ningún valor parecido devuelve el mensaje de no encontrado
    echo $resultado === "" ? "No se ha encontrado un usuario" : $resultado;