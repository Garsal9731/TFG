<?php

    session_start();

    // Usamos un booleano y usamos la cantidad de objetos para generar un bucle
    $eliminado = false;
    $cantidadObjetos = count($_SESSION["carrito"]);

    for($numeroObjeto=0;$numeroObjeto<$cantidadObjetos;$numeroObjeto++){
        if($eliminado==false){

            // Si se encuentra un objeto con el mismo nombre que el elegido se elimina y cambiamos el booleano para que no siga borrando
            if($_SESSION["carrito"][$numeroObjeto]==$_GET["producto"]){
                unset($_SESSION["carrito"][$numeroObjeto]);
                $eliminado = true;
            }
        }
    }

    // Cambiamos el orden del array para reorganizar los indices
    $_SESSION["carrito"] = array_values($_SESSION["carrito"]);

    // Redireccionamos al carrito para eliminar la acción de la URL
    header("Location: carrito.php");
    die();