<?php

    session_start();

    $cantidadObjetos = count($_SESSION["carrito"]);
        
    for($numeroObjeto=0;$numeroObjeto<$cantidadObjetos;$numeroObjeto++){
        if($_SESSION["carrito"][$numeroObjeto]==$_GET["producto"]){
            unset($_SESSION["carrito"][$numeroObjeto]);
        }
    }
    
    $_SESSION["carrito"] = array_values($_SESSION["carrito"]);

    header("Location: carrito.php");
    die();