<?php

    require '../Model/usuario.php';

    session_start();

    if($_GET["id"]==""){
        header('Location: login.php');
        die();
    }else{
        $idusuario = $_GET["id"];
        settype($idusuario, "integer");
        
        if(isset($_SESSION["usuario"])){
            $usuarioSesion = unserialize($_SESSION["usuario"]);
            $privilegio = $_SESSION["privilegio"];
        }
    }

    // ! NO FUNCIONA
    $usuario = Usuario::getUsuarioById($idusuario);


    include '../View/perfil.php';