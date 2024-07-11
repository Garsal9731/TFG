<?php

    require '../Model/usuario.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        $privilegio = 2;
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    $usuario = Usuario::getUsuarioById($_SESSION["idPerfil"]);
    $tiendas = $usuario->getTiendasUsuario();

    include '../View/perfil.php';