<?php

    require '../Model/producto.php';

    session_start();

    // Comprobamos que la session está abierta, de no estarlo se envia al registro
    if(!isset($_SESSION["usuario"])){
        $privilegio = 2;
        if(!isset($_SESSION["carrito"])){
            $_SESSION["carrito"] = array();
        }
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    $data['productos'] = Producto::getProductos();

    include '../View/inicioTienda.php';