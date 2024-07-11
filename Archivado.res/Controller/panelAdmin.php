<?php
    require '../Model/usuario.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        header('Location: login.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
    }

    $data['usuarios'] = Usuario::getUsuarios();
    $data['productos'] = Producto::getProductos();

    include '../View/paginaAdmin.php';