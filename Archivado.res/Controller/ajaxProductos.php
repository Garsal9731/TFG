<?php

  // ! NO CAMBIADO
  require '../Model/producto.php';

  session_start();

  $resultadoBD = Producto::getProductos();

  // Usamos el parametro peticion 
  $peticion = $_REQUEST["peticion"];

  $resultado = "";

  // Comprobamos el input de la peticion junto a los nombres de la base de datos para buscar similitudes
  if ($peticion !== "") {
    $peticion = strtolower($peticion);
    $longitud = strlen($peticion);

    foreach($resultadoBD as $producto){
      $nombre = $producto->getNombre();
      if (stristr($peticion, substr($nombre, 0, $longitud))) {
        if($_SESSION["privilegio"]==1){
          $resultado ='<article class="tarjeta_producto">
            <h3>'.$producto->getNombre().'</h3>
            <img src="'.$producto->getFoto().'">
            <p>Precio: '.$producto->getPrecio().' €</p>
            <p>Unidades: '.$producto->getUnidades().'</p>
            <a href="../Controller/detallesTienda.php?idtienda='.$producto->getTienda().'">'.$producto->getNombreTienda().'</a>
            <a href="../Controller/comprar.php?producto='.$producto->getId().'">Añadir al carrito</a>
            <a href="../Controller/borrarProducto.php?idproducto='.$producto->getId().'">Borrar Producto</a>
          </article>';
        }else{
          $resultado ='<article class="tarjeta_producto">
            <h3>'.$producto->getNombre().'</h3>
            <img src="'.$producto->getFoto().'">
            <p>Precio: '.$producto->getPrecio().' €</p>
            <p>Unidades: '.$producto->getUnidades().'</p>
            <a href="../Controller/detallesTienda.php?idtienda='.$producto->getTienda().'">'.$producto->getNombreTienda().'</a>
            <a href="../Controller/comprar.php?producto='.$producto->getId().'">Añadir al carrito</a>
          </article>';
        }
      }
    }
  }

  // Si no encuentra ningún valor parecido devuelve el mensaje de no encontrado
  echo $resultado === "" ? "No se ha encontrado un producto" : $resultado;