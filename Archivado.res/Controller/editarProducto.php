<?php
    // ! NO CAMBIADO
    require '../Model/producto.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        header('Location: registro.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    $producto = Producto::getProductoById($_SESSION["productoEditar"]);

    include '../View/formularioCambioProducto.php';