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

    $tiendas = $usuarioSesion->getTiendasUsuario();

    include '../View/formularioProductos.php';