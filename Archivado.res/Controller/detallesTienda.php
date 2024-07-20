<?php

    // ! NO CAMBIADO
    require '../Model/tienda.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        $privilegio = 2;
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }
    
    $tienda = Tienda::getTiendaById($_GET["idtienda"]);
    $productos = Tienda::getProductos($_GET["idtienda"]);

    include '../View/verTienda.php';