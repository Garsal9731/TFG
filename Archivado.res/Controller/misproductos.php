<?php
require '../Model/usuario.php';

    session_start();

    // Comprobamos que la session está abierta, de no estarlo se envia al registro
    if(!isset($_SESSION["usuario"])){
        header('Location: login.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
    }

    $productos = $usuarioSesion->getProductosUsuario();

    include '../View/misProductos.php';