<?php

    session_start();

    require '../Model/producto.php';

    if(!isset($_SESSION["usuario"])){
        $privilegio = 2;
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    $cantidades = array_count_values($_SESSION["carrito"]);
    $arrayCarrito = array_unique($_SESSION["carrito"]);

    include '../View/vistaCarrito.php';