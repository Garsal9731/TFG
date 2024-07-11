<?php
  require '../Model/tienda.php';
  $resultadoBD = Tienda::getTiendas();

  // Usamos el parametro peticion 
  $peticion = $_REQUEST["peticion"];

  $resultado = "";

  // Comprobamos el input de la peticion junto a los nombres de la base de datos para buscar similitudes
  if ($peticion !== "") {
    $peticion = strtolower($peticion);
    $longitud = strlen($peticion);

    foreach($resultadoBD as $tienda){
      $nombre = $tienda->getNombre();
      if (stristr($peticion, substr($nombre, 0, $longitud))) {
        $usuario = $tienda::getPropietarioById($tienda->getPropietario());
        $resultado ='<article class="tarjeta_tienda">
          <h3>'.$tienda->getNombre().'</h3>
          <p>'.$tienda->getDescripcion().'</p>    
          Proveedor: <a href="../Controller/recogerId.php?idPerfil='.$usuario["idusuario"].'">'.$usuario["nombre"].'</a>
          <p><a href="../Controller/detallesTienda.php?idtienda='.$tienda->getId().'">Ver detalles.</a></p>

        </article>';
      }
    }
  }

  // Si no encuentra ningún valor parecido devuelve el mensaje de no encontrado
  echo $resultado === "" ? "No se ha encontrado un producto" : $resultado;